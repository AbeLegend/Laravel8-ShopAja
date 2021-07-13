<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'item_name',
        'item_image',
        'item_description',
        'item_stock',
        'price'
    ];

    public function addCart()
    {
        return $this->hasOne(Cart::class, 'id_item');
    }
}
