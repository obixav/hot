<?php

namespace App\Models;

use App\Enums\ListingPlatform;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;
    protected $fillable = ['uuid','platform'];

    protected $casts = ['platform'=>ListingPlatform::class];

    public function messages()
    {
        return $this->hasMany(Message::class,'listing_id');
    }

}
