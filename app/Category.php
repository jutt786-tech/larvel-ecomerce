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

    public function categories(){
        return $this->hasMany(Category::class);
    }

    public function childrenCategories(){
        return $this->hasMany(Category::class)->with('categories');
    }


//    public function childrens(){
//        return $this->hasMany( Category::class, 'parent_id' );
//    }
//    public function parent(){
//        return $this->belongsTo( Category::class, 'parent_id' );
//    }


    public function  children() {
        return $this->belongsToMany(Category::class , 'category_parents', 'category_id', 'parent_id');
    }

//    public function childrens()
//    {
//        return $this->hasMany(Category::class , 'category_parent', 'category_id', 'parent_id');
//    }
}
