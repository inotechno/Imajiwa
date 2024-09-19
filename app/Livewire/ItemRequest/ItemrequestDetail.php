<?php

namespace App\Livewire\ItemRequest;

use App\Models\CategoryInventory;
use App\Models\Inventory;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ItemrequestDetail extends Component
{
    use LivewireAlert;
    public $items = [];
    public $inventory;
    public $categories;
    public $name, $request_id, $description, $slug, $status_id, $category_inventory_id, $serial_number, $image_path, $image_url, $qr_code_path, $qr_code_url, $purchase_date, $price, $model, $qty, $director_id, $commissioner_id, $director_approved_at, $commissioner_approved_at;
    public $isCommissioner = false;
    public $isDirector = false;
    public $disableUpdate = false;
    public $approvedDirector = false;
    public $approvedCommissioner = false;
    public $type = 'create';

    public function mount($id = null)
    {
        $this->categories = CategoryInventory::get();
        $request = \App\Models\Request::with(['inventories.directorApprovedItem', 'inventories.commissionerApprovedItem'])->find($id);

        if ($request) {
            $this->request_id = $request->id;
            $this->name = $request->name;

            foreach ($request->inventories as $inventory) {
                $this->items[] = [
                    'id' => $inventory->id,
                    'name' => $inventory->name,
                    'description' => $inventory->description,
                    'serial_number' => $inventory->serial_number,
                    'model' => $inventory->model,
                    'qty' => $inventory->qty,
                    'price' => $inventory->price,
                    'purchase_date' => $inventory->purchase_date,
                    'category_inventory_id' => $inventory->category_inventory_id,
                ];
            }

            $this->type = 'update';


            if ($request->director_approved_at) {
                $this->approvedDirector = true;
            }

            if ($request->commissioner_approved_at) {
                $this->approvedCommissioner = true;
            }

            if ($this->approvedDirector || $this->approvedCommissioner) {
                $this->disableUpdate = true;
            }

            if (Auth::user()->employee && $request->director_id == Auth::user()->employee->id) {
                $this->isDirector = true;
            }

            if (Auth::user()->employee && $request->commissioner_id == Auth::user()->employee->id) {
                $this->isCommissioner = true;
            }
        } else {
            $this->items[] = $this->emptyItem();
        }
    }

    #[On('approve:item-request')]
    public function approve()
    {
        if ($this->isDirector) {
            $this->leave_request->update([
                'director_approved_at' => now(),
            ]);
        }

        if ($this->isSupervisor) {
            $this->leave_request->update([
                'supervisor_approved_at' => now(),
            ]);
        }

        $this->alert('success', 'Item Request approved successfully');
        return redirect()->route('item-request.index');
    }

    public function render()
    {
        return view('livewire.item-request.itemrequest-detail')->layout('layouts.app', ['title' => 'Form Item Request']);
    }
}
