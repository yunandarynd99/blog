<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //Get /api /categories
    public function index()
    {
        return Category::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    // POST / api/ categories
    public function store(Request $request)
    {
        $validator = validator(request()->all(),
        [
            "name" => "required"
        ]);

        if($validator->fails())
        {
            return response($validator->errors(), 400);
        }

        $category = new Category;
        $category->name = request()->name;
        $category->save();

        return $category;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */

    // GET / api/ categories/id
    public function show($id)
    {
        return Category::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */

    //PUT / api/ categories/id
    public function update(Request $request, $id)
    {
        if(!request()->name)
        {
            return ["msg" => "Name required"];
            //return response(["msg" => "Name required"], 400);
        }

        $category = Category::find($id);
        $category->name = request()->name;
        $category->save();

        return $category;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */

    //DELETE / api/ categories/id
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return $category;
    }
}
