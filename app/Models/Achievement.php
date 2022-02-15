<?php

namespace App\Models;

use App\Events\AchievementCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Achievement extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    protected $dispatchesEvents = [
        'created' => AchievementCreated::class,
    ];
    public function achievable(){
        return $this->morphTo(__FUNCTION__,"achievable_type","achievable_id");
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
