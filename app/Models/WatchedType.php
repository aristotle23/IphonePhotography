<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WatchedType extends Model
{
    use HasFactory;
    public function achievement(){

        return $this->morphOne(Achievement::class,"achievable");
        
    }
}
