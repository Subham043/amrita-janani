<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AudioFavourite extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "audio_favourites";

    public function User()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    
    public function AudioModel()
    {
        return $this->belongsTo('App\Models\AudioModel', 'audio_id');
    }
}
