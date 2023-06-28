<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = ['listing_id','body'];

    public function listing()
    {
        return $this->belongsTo(Listing::class,'listing_id');
    }
}
