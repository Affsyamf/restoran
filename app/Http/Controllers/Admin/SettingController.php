<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Menampilkan halaman form pengaturan.
     */
    public function index()
    {
        // Ambil semua setting dan ubah menjadi format key => value agar mudah diakses di view
        $settings = Setting::pluck('value', 'key')->all();
        
        return view('admin.settings.index', ['settings' => $settings]);
    }

    /**
     * Menyimpan perubahan pengaturan.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'required|string|max:500',
            'about_title' => 'required|string|max:255',
            'about_text' => 'required|string',
            'contact_phone' => 'required|string|max:50',
        ]);

        foreach ($validated as $key => $value) {
            // Gunakan updateOrCreate untuk membuat setting baru jika belum ada, atau update jika sudah ada.
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return back()->with('success', 'Pengaturan situs berhasil diperbarui.');
    }
}
