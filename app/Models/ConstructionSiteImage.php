<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ConstructionSiteImage extends Model
{ 
    use HasFactory;
    
    const UPDATED_AT = null;

    protected $table = 'construction_site_images';   
}
