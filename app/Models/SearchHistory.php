<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SearchHistory extends Model
{
    use HasFactory, SoftDeletes;
    protected $table="search_histories";

    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }
    

}
