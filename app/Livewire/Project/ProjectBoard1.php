<?php

namespace App\Livewire\Project;

use App\Events\CardCreated;
use App\Events\CardDeleted;
use App\Events\CardMoved;
use App\Events\CardUpdated;
use App\Events\ConnectorCreated;
use App\Models\BoardAsset;
use App\Models\BoardCard;
use App\Models\BoardConnector;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ProjectBoard1 extends Component
{
    use LivewireAlert, WithFileUploads;

    public $project;
    public $projectId;
    public $cards = [];

    // ✅ Upload state
    public $upload;
    public $uploadIntent; // 'image' | 'file'
    public $connectors = []; // 🟢 tambahkan ini

    protected $listeners = [
        'updateCardPosition' => 'updateCardPosition',
        'updateCardSize'     => 'updateCardSize',
        'updateCardContent'  => 'updateCardContent',
        'createCard'         => 'createCard',
        'createCardFromData' => 'createCardFromData',
        'createCardOfType'   => 'createCardOfType',
        'deleteCard'         => 'deleteCard',
        'bringToFront'       => 'bringToFront',
        'file-selected' => 'setUploadIntent',
        'createConnector'    => 'createConnector',
    ];

    public function setUploadIntent($data = null)
    {
        $this->uploadIntent = $data['type'] ?? null;
    }

    public function mount(Project $project)
    {
        $this->project   = $project;
        $this->projectId = $project->id;
        $this->cards     = BoardCard::where('project_id', $project->id)->get()->toArray();
        $this->connectors = BoardConnector::where('project_id', $project->id)->get()->toArray(); // 🟢 tambahkan ini
    }

    public function createConnector($from = null, $to = null)
    {

        if (!$from || !$to || $from == $to) return;

        $connector = BoardConnector::create([
            'project_id'   => $this->projectId,
            'from_card_id' => $from,
            'to_card_id'   => $to,
            'style'        => 'line',
            'color'        => '#A0AEC0',
            'thickness'    => 2,
        ]);

        broadcast(new ConnectorCreated($connector))->toOthers();
        $this->dispatch('connectorCreatedLocal', $connector->toArray());
    }

    // =====================================================
    // ✅ Create Card (Toolbar Button)
    // =====================================================
    public function createCardOfType($type = 'text')
    {
        // Jika data datang dalam bentuk array, ambil nilai type-nya
        if (is_array($type) && isset($type['type'])) {
            $type = $type['type'];
        }

        $content = match ($type) {
            'note'  => 'Sticky Note',
            'image' => null,
            'file'  => null,
            default => 'New card',
        };

        $card = BoardCard::create([
            'project_id' => $this->projectId,
            'type'       => $type,
            'content'    => $content,
            'x'          => 120,
            'y'          => 120,
            'w'          => $type === 'note' ? 220 : 200,
            'h'          => $type === 'note' ? 160 : 120,
            'z_index'    => (BoardCard::where('project_id', $this->projectId)->max('z_index') ?? 0) + 1,
            'updated_by' => null,
        ]);

        broadcast(new CardCreated($card))->toOthers();
        $this->dispatch('cardCreatedLocal', $card->toArray());
    }


    // =====================================================
    // 📤 Upload File / Image
    // =====================================================
    public function updatedUpload()
    {
        if (!$this->upload) return;

        $this->validate([
            'upload' => 'file|max:10240', // 10 MB
        ]);

        // simpan fisik
        $path = $this->upload->store('board_assets', 'public');
        $mime = $this->upload->getMimeType();
        $type = $this->uploadIntent ?: (str_starts_with($mime, 'image/') ? 'image' : 'file');
        $url  = asset('storage/' . $path); // URL publik

        // simpan meta asset
        BoardAsset::create([
            'project_id'  => $this->projectId,
            'filename'    => $this->upload->getClientOriginalName(),
            'path'        => $path,
            'mime_type'   => $mime,
            'extension'   => $this->upload->getClientOriginalExtension(),
            'size'        => $this->upload->getSize(),
            'uploaded_by' => null,
        ]);

        // ukuran default
        $width  = 240;
        $height = 180;

        // auto-size khusus image
        if ($type === 'image') {
            $fullPath = storage_path('app/public/' . $path);

            // getimagesize bisa false/0 untuk beberapa format (mis. AVIF)
            $dims = @getimagesize($fullPath);
            $imgWidth  = is_array($dims) && !empty($dims[0]) ? (int)$dims[0] : 0;
            $imgHeight = is_array($dims) && !empty($dims[1]) ? (int)$dims[1] : 0;

            if ($imgWidth > 0 && $imgHeight > 0) {
                // batas maksimum agar tidak kelewat besar di kanvas
                $maxWidth  = 480;
                $maxHeight = 360;

                $scaleW = $maxWidth  / $imgWidth;
                $scaleH = $maxHeight / $imgHeight;

                // hindari pembagian dengan nol dan pastikan skala <= 1
                $scale = min($scaleW > 0 ? $scaleW : 1, $scaleH > 0 ? $scaleH : 1, 1);

                $width  = (int) max(60, round($imgWidth  * $scale));  // kasih min size kecil
                $height = (int) max(60, round($imgHeight * $scale));
            } else {
                // fallback kalau ukuran tidak terbaca
                $width  = 300;
                $height = 220;
            }
        }

        // buat card
        $card = BoardCard::create([
            'project_id' => $this->projectId,
            'type'       => $type,
            'content'    => $url,
            'x'          => 140,
            'y'          => 140,
            'w'          => $width,
            'h'          => $height,
            'z_index'    => (BoardCard::where('project_id', $this->projectId)->max('z_index') ?? 0) + 1,
            'updated_by' => null,
        ]);

        broadcast(new CardCreated($card))->toOthers();
        $this->dispatch('cardCreatedLocal', $card->toArray());

        $this->reset(['upload', 'uploadIntent']);
    }

    // =====================================================
    // 🗂️ CRUD Core
    // =====================================================
    public function bringToFront($id)
    {
        $maxZ = BoardCard::where('project_id', $this->projectId)->max('z_index') ?? 0;
        if ($card = BoardCard::find($id)) {
            $card->update(['z_index' => $maxZ + 1]);
            broadcast(new CardUpdated($card))->toOthers();
        }
    }

    public function updateCardSize($id, $w, $h)
    {
        if ($card = BoardCard::find($id)) {
            $card->update(['w' => $w, 'h' => $h]);
            broadcast(new CardUpdated($card))->toOthers();
        }
    }

    public function deleteCard($id)
    {
        if ($card = BoardCard::find($id)) {
            $projectId = $card->project_id;
            $card->delete();

            broadcast(new CardDeleted($id, $projectId))->toOthers();
            $this->dispatch('cardDeletedLocal', $id);
        }
    }

    public function createCardFromData($payload = [])
    {
        $data = $payload['data'] ?? $payload;

        // GUARD: cegah pembuatan card text kosong (kemungkinan trigger kedua yang tidak diinginkan)
        $isClientAction = isset($payload['clientId']) && !empty($payload['clientId']);
        if ($isClientAction && isset($data['type']) && $data['type'] === 'text' && (!isset($data['content']) || $data['content'] === null || $data['content'] === '')) {
            \Log::debug('createCardFromData GUARD: skip empty text card', ['payload' => $payload]);
            return null;
        }

        $fields = (new BoardCard)->getFillable();
        $finalData = [];
        foreach ($fields as $f) {
            if (array_key_exists($f, $data) && $f !== 'id' && $f !== 'project_id' && $f !== 'z_index') {
                $finalData[$f] = $data[$f];
            }
        }
        $finalData['project_id'] = $this->projectId;
        $finalData['z_index'] = (BoardCard::where('project_id', $this->projectId)->max('z_index') ?? 0) + 1;
        $finalData['x'] = isset($finalData['x']) && $finalData['x'] !== '' ? (int)$finalData['x'] : 120;
        $finalData['y'] = isset($finalData['y']) && $finalData['y'] !== '' ? (int)$finalData['y'] : 120;
        if (empty($finalData['type']) && isset($data['type'])) $finalData['type'] = $data['type'];
        if (empty($finalData['content']) && isset($data['content'])) $finalData['content'] = $data['content'];

        \Log::debug('createCardFromData', [
            'clientId' => $payload['clientId'] ?? null,
            'data' => $data,
            'finalData' => $finalData,
        ]);

        $card = BoardCard::create($finalData);
        broadcast(new CardCreated($card))->toOthers();
        $this->dispatch('cardCreatedLocal', $card->toArray());
        return $card->toArray();
    }

    public function createCard()
    {
        $card = BoardCard::create([
            'project_id' => $this->project->id,
            'type'       => 'text',
            'content'    => 'New card',
            'x'          => 100,
            'y'          => 100,
            'w'          => 200,
            'h'          => 100,
            'z_index'    => 1,
            'updated_by' => null,
        ]);

        broadcast(new CardCreated($card))->toOthers();
        $this->dispatch('cardCreatedLocal', $card->toArray());
    }

    public function updateCardPosition($id, $x, $y)
    {
        if ($card = BoardCard::find($id)) {
            $card->update(['x' => $x, 'y' => $y]);
            // broadcast(new CardUpdated($card))->toOthers();
            broadcast(new CardMoved($card))->toOthers();
        }
    }

    public function updateCardContent($id, $content)
    {
        if ($card = BoardCard::find($id)) {
            $card->update(['content' => $content, 'updated_by' => null]);
            broadcast(new CardUpdated($card))->toOthers();
        }
    }

    // =====================================================
    // 🔍 View
    // =====================================================
    public function render()
    {
        return view('livewire.project.project-board')
            ->layout('layouts.app', [
                'title' => 'Project Board - ' . $this->project->name,
            ]);
    }
}
