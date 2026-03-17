<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PropertyFloorPlan extends Model
{ 
    protected $table = 'properties_floor_plans';

    protected static function booted()
    {
        static::deleting(function ($img) {
            if($img->path){
                Storage::disk('public')->delete("properties_floor_plans/".$img->path);
            }
        });
    }
}
