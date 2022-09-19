<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Services;

class Brands extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = "brands";

    protected $fillable = [
        'brand_name',
        'brand_contact',
        'brand_email',
        'brand_picture'
    ];

    /**
     * Get the images for the nft.
    */
    public function services()
    {
        return $this->belongsToMany(Services::class, 'brands_services','brand_id','service_id');
    }

    /**
     * Get the images for the nft.
    */
    public function users()
    {
        return $this->hasMany(User::class, 'brand_id');
    }

}
