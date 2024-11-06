<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductIngredient extends Model
{
    protected $guarded = ['id'];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
