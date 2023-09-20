<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvertisementImage extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;


    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class);
    }
}
