<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LanguageModel extends Model
{
    use HasFactory;
    protected $table="languages";

    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }

}
