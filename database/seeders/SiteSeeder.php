<?php

namespace Database\Seeders;

use App\Models\Site;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $uid = Str::uuid();
        Site::create([
            'uid' => $uid,
            'name' => 'TPM Group',
            'longitude' => '106.798818',
            'latitude' => '-6.263122',
            'address' => 'Kompleks Dutamas Fatmawati Blok B2 No. 26, RT.1/RW.5, Cipete Utara, Kec. Kby. Baru, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12150',
            'qrcode_url' => 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=TPM+Group',
            'qrcode_path' => 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=TPM+Group',
        ]);

        Site::factory(10)->create();
    }
}
