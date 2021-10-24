<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Image extends Model
{
    protected $guarded = [];

    /**
     * @param string $ownerId
     * @param string $ownerType
     * @return Collection
     */
    public static function getAllImagesForOwner(string $ownerId, string $ownerType): Collection
    {
        return DB::table('images')
            ->join('image_mappers', 'images.id', '=', 'image_mappers.image_id')
            ->where('owner_id', $ownerId)
            ->where('owner_type', $ownerType)
            ->get();
    }
}
