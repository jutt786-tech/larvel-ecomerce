<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\DeclareDeclare;
use Illuminate\Support\Facades\Validator;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
      $categories = Category::with('children')->get();

        return view('admin.category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
      $categories = Category::all();
        return  view('admin.category.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        Validator::make($request->all(), [
            'title' => 'required|unique:categories|max:255',
            'description' => 'required',
        ])->validate();

      $cate=  Category::create([
            'title' =>$request->title,
            'description' => $request->description
        ]);
      $cate->children()->attach($request->parent_id);
      return  redirect(route('admin.category.index'))->with('message','Category inserted sucessfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit( Category  $category)
    {
        //
       $cat = Category::all();
       return view('admin.category.create',['cat'=>$cat, 'category'=>$category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        //

        $cid = Category::find($id);
        $cid->title = $request->title;
        $cid->description = $request->description;
        $cid->save();
        $cid->children()->sync($request->parent_id);

        return redirect(route('admin.category.index'))->with('message','Data updated sucessfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        //
       $cid = Category::findOrFail($id);
       $cid->delete();
       return redirect(route('admin.category.index'))->with('message','Data Delet Sucessfully');
    }
}
