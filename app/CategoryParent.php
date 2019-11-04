<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryParent extends Model
{
    protected $table = "category_parents";




//    public function children()
//    {
//        return $this
//            ->hasMany('App\Category', 'parent_id' )
//            ->select( "parent_id", "id", "title"); //I wasn't selecting this guy
//        //->with("children2") // With this i got the way to concatenate a lot of subchildren map :D
//
//    }







//    public function  children() {
//        return $this->belongsToMany(Category::class , 'category_parents', 'category_id', 'parent_id');
//    }



//    public function childrens(){
//        return $this->belongsTo( Category::class );
//    }



//    public function  category() {
//        return $this->belongsTo(Category::class);
//    }


//    public function getChildCategories(){
//        return $this->hasMany('App\Category', 'category_id');
//    }



}
