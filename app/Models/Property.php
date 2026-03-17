<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Models\PropertyFloor;
use App\Models\PropertyRoom;
use App\Models\PropertyImage;
use App\Models\PropertyFloorPlan;
use App\Models\PropertyImage360;

class Property extends Model
{ 
    protected $table = 'properties';
    
    public function images(){
        return PropertyImage::where("id_property", $this->id)->get();
    }

    public function images360(){
        return PropertyImage360::where("id_property", $this->id)->get();
    }

    public function floorPlans(){
        return PropertyFloorPlan::where("id_property", $this->id)->get();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });

    }    

    protected static function booted()
    {
        static::deleting(function ($property) {

            foreach ($property->images() as $img) {
                $img->delete(); 
            }

            foreach ($property->images360() as $img) {
                $img->delete(); 
            }

            foreach ($property->floorPlans() as $plan) {
                $plan->delete(); 
            }
        });
    }
}
