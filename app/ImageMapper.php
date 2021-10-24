<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageMapper extends Model
{
    protected $table = 'image_mappers';

    protected $fillable = ['image_id', 'owner_id', 'owner_type'];
}
