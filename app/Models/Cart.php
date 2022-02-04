<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

     protected $fillable = ['inventory_id', 'user_id', 'name', 'price', 'quantity'];

    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
