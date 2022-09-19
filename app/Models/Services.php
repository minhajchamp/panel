<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Brands;

class Services extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = "services";

    protected $fillable = [
        'service_name',
        'service_picture'
    ];

    /**
     * Get the images for the nft.
    */
    public function brands()
    {
        return $this->belongsToMany(Brands::class, 'brands_services','service_id','brand_id');
    }

}
