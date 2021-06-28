<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductsModel extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $guarded = array();
}
