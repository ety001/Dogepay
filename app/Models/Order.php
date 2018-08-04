<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $table = 'orders';

    // Status
    const UNPAY = 0;
    const PAID = 1;
    const CLOSED = 2;
}
