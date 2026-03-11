<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Property;
use App\Models\ConstructionSite;

class Message extends Model
{
    protected $table = 'messages';

    const UPDATED_AT = null;

    public function getProperty(){
        if(!$this->id_property){
            return;
        }

        return Property::find($this->id_property);
    }

    public function getConstructionSite(){
        if(!$this->id_construction_site){
            return;
        }

        return ConstructionSite::find($this->id_construction_site);
    }
}
