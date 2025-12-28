<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'email',
        'civility',
        'company',
        'last_name',
        'first_name',
        'address',
        'postal_code',
        'city',
        'country',
    ];
}
