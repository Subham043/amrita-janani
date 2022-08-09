<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentFavourite extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "document_favourites";

    public function User()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    
    public function DocumentModel()
    {
        return $this->belongsTo('App\Models\DocumentModel', 'document_id');
    }
}
