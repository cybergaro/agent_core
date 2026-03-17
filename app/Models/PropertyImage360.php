<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PropertyImage360 extends Model
{ 
    protected $table = 'properties_360_images';
    
    protected static function booted()
    {
        static::deleting(function ($img) {
            if($img->path){
                Storage::disk('public')->delete("properties_360_images/".$img->path);
            }
        });
    }
}
