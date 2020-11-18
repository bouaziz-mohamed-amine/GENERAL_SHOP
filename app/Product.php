<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable=[
        'title','description','unit','price',
        'total'
    ];
    public function category(){
        return $this->belongsTo(Category::class );
    }
    public function images(){
        return $this->hasMany(Image::class);
    }
    public function hasUnit(){
        return $this->belongsTo(Unit::class ,'unit' , 'id' );
    }
}
