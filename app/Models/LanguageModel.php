<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LanguageModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table="languages";

    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function Image()
    {
        return $this->hasMany('App\Models\ImageModel');
    }

    public function Audio()
    {
        return $this->hasMany('App\Models\AudioModel');
    }

    public function Video()
    {
        return $this->hasMany('App\Models\VideoModel');
    }

    public function Document()
    {
        return $this->hasMany('App\Models\DocumentModel');
    }
    

}
