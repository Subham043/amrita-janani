<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AudioAccess extends Model
{
    use HasFactory;

    protected $table = "audio_access";

    public function User()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    
    public function Admin()
    {
        return $this->belongsTo('App\Models\User', 'admin_id');
    }
    
    public function AudioModel()
    {
        return $this->belongsTo('App\Models\AudioModel', 'audio_id');
    }
}
