<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotels extends Model
{
    protected $table = 'hotels';

    public $fillable = [
        'h_name', 'h_description', 'h_admin', 'h_address'
    ];
}
