<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrdersModel extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $guarded = array();
}
