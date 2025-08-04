<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    //
    use HasFactory;

    protected $fillable = [
        'nama_menu',
        'deskripsi',
        'harga',
        'kategori',
        'gambar',
    ];

     public function orderItems(): HasMany // <-- TAMBAHKAN METHOD INI
    {
        return $this->hasMany(OrderItem::class);
    }
}
