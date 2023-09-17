<?php

namespace App\Models\Product;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = [
        "title",
        "categorie_id",
        "slug",
        "sku",
        "tags",
        "price_soles",
        "price_usd",
        "resumen",
        "description",
        "state",
        "imagen",
        "stock"
    ];

    public function setCreatedAtAttribute($value)
    {
        date_default_timezone_set("America/Lima");
        $this->attributes["created_at"] = Carbon::now();
    }

    public function setUpdatedAtAttribute($value)
    {
        date_default_timezone_set("America/Lima");
        $this->attributes["updated_at"] = Carbon::now();
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function sizes()
    {
        return $this->hasMany(ProductSize::class);
    }

    public function scopefilterProduct($query,$search)
    {
        if($search){
            $query->where("title","like","%".$search."%");
        }
       /*  if($categorie_id){
            $query->where("categorie_id",$categorie_id);
        } */
        return $query;
    }
}
