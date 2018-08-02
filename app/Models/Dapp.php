<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dapp extends Model
{
    use SoftDeletes;

    // Status
    const ONLINE = 1;
    const TESTING = 0;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $table = 'dapp';
}
