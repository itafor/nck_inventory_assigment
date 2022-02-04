<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'name', 'price', 'quantity'];

    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // public function cart()
    // {
    // 	return $this->hasOne(Cart::class, 'inventory_id', 'id');
    // }
}
