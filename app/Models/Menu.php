<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{

    

    //
    use HasFactory;

    protected $fillable = [
        'nama_menu',
        'deskripsi',
        'harga',
        'kategori',
        'gambar',
        'is_available',
    ];

    protected function casts(): array
        {
            return [
                'is_available' => 'boolean', 
            ];
        }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

     public function orderItems(): HasMany 
    {
        return $this->hasMany(OrderItem::class);
    }
}
