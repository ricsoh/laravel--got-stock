<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

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
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // => ME, create and save category
    public function store(Request $request)
    {
        $data = request()->validate([
            'category_main_cat' => 'required',
            'category_subcat_1' => 'required',
        ]);
 
        $user = Auth::user();
        $category = new Category();
            
        $category->user_id = $user->id;

        $category->main_cat = request('category_main_cat');
        $category->subcat_1 = request('category_subcat_1');

        $saved = $category->save();
        if ($saved) {
            return redirect('/home');
        }        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $categoryID)
    {
        $data = request()->validate([
            'category_main_cat' => 'required',
            'category_subcat_1' => 'required',
        ]);

        $user = Auth::user();
        $category = Category::find($categoryID); // This is for updating selected ID
        
        $category->main_cat = request('category_main_cat');
        $category->subcat_1 = request('category_subcat_1');

        $saved = $category->save();
        if ($saved) {
            return redirect('/home');
        }        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($categoryID)
    {
        $delete = Category::where('id', $categoryID)->first();
        $deleted = Category::where('id', $categoryID)->delete();

        if ($deleted) {
            return redirect('/home');
        }
    }
}
