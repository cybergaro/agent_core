<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ConstructionSiteUnit extends Model
{ 
    use HasFactory;

    protected $table = 'construction_site_units';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }    

    public function firstImage()
    {
        return $this->hasOne(ConstructionSiteImage::class, 'id_construction_site_unit');
    }

    public function getFirstImagePath()
    {
        return $this->firstImage?->path;
    }
}
