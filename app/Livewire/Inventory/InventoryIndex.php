<?php

namespace App\Livewire\Inventory;

use App\Models\Inventory;
use Livewire\Component;
use Livewire\Attributes\Url;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

class InventoryIndex extends Component
{
    use LivewireAlert, WithPagination;
    public $inventory;
    #[Url(except: '')]
    public $search = '';
    public $perPage = 10;
    public $showForm;
    public $mode = 'create';


    protected $listeners = [
        'refreshIndex' => 'handleRefresh',
    ];

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function handleRefresh()
    {
        logger('Refreshing index');
        $this->alert('success', 'Refreshed successfully');
        $this->dispatch('$refresh');
    }

    public function resetFilter()
    {
        $this->search = "";
        $this->resetPage();
    }

    public function updateQrCodePathForEmpty()
    {
        try {
            // Mendapatkan semua inventory dengan qr_code_path kosong atau null
            $inventories = Inventory::whereNull('qr_code_path')
                ->orWhere('qr_code_path', '')
                ->get();

            // Iterasi dan update setiap entri dengan qr_code_path yang kosong
            foreach ($inventories as $inventory) {
                // Membuat qr_code baru
                $randomQrCode = Str::random(4);

                // Memperbarui qr_code_path
                $inventory->update([
                    'qr_code_path' => $randomQrCode,
                ]);
            }

            $this->alert('success', 'QR Code paths updated successfully');
        } catch (\Exception $e) {
            $this->alert('error', 'Error: ' . $e->getMessage());
        }
    }

    // public function downloadAllQrCodes()
    // {
    //     try {
    //         $inventories = Inventory::all();

    //         if ($inventories->isEmpty()) {
    //             $this->alert('error', 'Tidak ada data inventory untuk didownload');
    //             return;
    //         }

    //         $pdf = app('dompdf.wrapper');

    //         $html = '<h1 style="text-align: center;">Daftar QR Code</h1>';
    //         foreach ($inventories as $inventory) {
    //             if (empty($inventory->qr_code_path)) {
    //                 $inventory->qr_code_path = Str::random(4);
    //                 $inventory->save();
    //             }

    //             $qrCode = DNS2D::getBarcodePNG(url('/inv/' . $inventory->qr_code_path), 'QRCODE');
    //             $html .= '<div style="margin-bottom: 20px; text-align: center;">';
    //             $html .= '<img src="data:image/png;base64,' . $qrCode . '" alt="QR Code">';
    //             $html .= '<p><strong>' . $inventory->name . '</strong></p>';
    //             $html .= '</div>';
    //         }


    //         $pdf->loadHTML($html);
    //         return response()->streamDownload(function () use ($pdf) {
    //             echo $pdf->stream();
    //         }, 'All_QR_Codes.pdf');
    //     } catch (\Exception $e) {
    //         $this->alert('error', 'Error: ' . $e->getMessage());
    //     }
    // }


    public function render()
    {
        $inventories = Inventory::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })
            ->whereNotNull('director_approved_at')
            ->whereNotNull('commissioner_approved_at')
            ->paginate($this->perPage);

        return view('livewire.inventory.inventory-index', compact('inventories'))->layout('layouts.app', ['title' => 'Inventory']);
    }
}
