<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentReport extends Model
{
    use HasFactory;

    protected $table = "document_reports";

    public function User()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    
    public function Admin()
    {
        return $this->belongsTo('App\Models\User', 'admin_id');
    }
    
    public function DocumentModel()
    {
        return $this->belongsTo('App\Models\DocumentModel', 'document_id');
    }
}
