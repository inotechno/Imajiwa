<?php

namespace App\Console\Commands;

use App\Models\Inventory;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateQrCodesForOldInventories extends Command
{
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-qr-codes-for-old-inventories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $inventories = Inventory::whereNull('qr_code_path')->get();

        foreach ($inventories as $inventory) {
            $inventory->qr_code_path = Str::random(4); // Generate random QR code
            $inventory->save();
            $this->info("QR Code generated for Inventory ID: {$inventory->id}");
        }

        $this->info('QR Codes generated for all old inventories.');
    }
}
