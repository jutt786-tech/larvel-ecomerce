<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected  $guarded = [];

    public function products(){
       return $this->belongsToMany('App\Product');

    }

    public function  children() {
        return $this->belongsToMany(Category::class , 'category_parent', 'category_id', 'parent_id');
    }
}
