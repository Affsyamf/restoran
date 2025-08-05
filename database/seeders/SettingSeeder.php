<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'hero_title', 'value' => 'Sajikan Momen Terbaik Bersama Kami.'],
            ['key' => 'hero_subtitle', 'value' => 'Nikmati hidangan istimewa yang dibuat dari bahan-bahan segar pilihan, disajikan dengan cinta dan kehangatan.'],
            ['key' => 'about_title', 'value' => 'Cerita di Balik Cita Rasa'],
            ['key' => 'about_text', 'value' => 'Restoran Enak lahir dari kecintaan kami terhadap masakan otentik dan keinginan untuk menciptakan tempat di mana setiap orang bisa menikmati makanan lezat dalam suasana yang nyaman dan hangat.'],
            ['key' => 'contact_phone', 'value' => '(021) 123-4567'],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
