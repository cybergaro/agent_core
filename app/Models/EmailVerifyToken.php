<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EmailVerifyToken extends Model
{ 
    protected $table = 'email_verify_tokens';  
    
    public function createToken($idUser)
    {
        $token = Str::random(60);
        $this->id_user = $idUser;
        $this->token = $token;
        $this->save();
        
        return $token;
    }
}
