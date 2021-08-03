<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';

    public $fillable = [
        'b_u_id', 'b_h_id', 'b_start_date', 'b_end_date'
    ];
}
