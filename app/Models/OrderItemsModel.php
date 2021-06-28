<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItemsModel extends Model
{
    use HasFactory;

    protected $table = 'order-items';
    protected $guarded = array();
}
