<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::set('app_name', 'Stockify Project');
        Setting::set('app_description', 'Sistem Manajemen Stok Barang');
        Setting::set('app_logo', null);
        Setting::set('low_stock_notification', 'true');
    }
}