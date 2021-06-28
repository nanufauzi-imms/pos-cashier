<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionsModel extends Model
{
    use HasFactory;

    protected $table = 'transactions';
    protected $guarded = array();
}
