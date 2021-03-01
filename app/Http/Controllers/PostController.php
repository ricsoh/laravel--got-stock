<?php

namespace App\Http\Controllers;

use App\Models\Post;
//use Facade\FlareClient\Stacktrace\File as StacktraceFile;
//use Faker\Provider\File as ProviderFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;

class PostController extends Controller
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
    // ME => for creating a new post
    public function store(Request $request)
    {
        $data = request()->validate([
            'post_main_cat_sel' => 'required',
            'post_subcat_1_sel' => 'required',
        ]);
 
        $user = Auth::user();
        $post = new Post();

        $post->user_id = $user->id;

        $post->main_cat = request('post_main_cat_sel');
        $post->subcat_1 = request('post_subcat_1_sel');
        $post->brand = request('post_brand');
        $post->description = request('post_description');
        $post->qty = request('post_qty');
        $post->price = request('post_price');

        // If image file available, save it
//        if (request()->has('post_image')) {
        if (!empty(request('post_image'))) {
            $imagePath = request('post_image')->store('uploads', 'public');
            $post->image = $imagePath;
        }else{
            $imagePath = "../images/no_image.jfif"; // Add no image picture
            $post->image = $imagePath;
        }

        $saved = $post->save();
        if ($saved) {
            return redirect('/home');
        }        
    }
 
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    // ME => for editing a existing post
    public function update(Request $request, $postID)
    {
        $data = request()->validate([
            'post_main_cat' => 'required',
            'post_subcat_1' => 'required',
        ]);

        $user = Auth::user();
        $post = Post::find($postID); // This is for updating selected ID

        $post->main_cat = request('post_main_cat');
        $post->subcat_1 = request('post_subcat_1');
        $post->brand = request('post_brand');
        $post->description = request('post_description');
        $post->qty = request('post_qty');
        $post->price = request('post_price');

        // If image file available, save it
        if (!empty(request('post_image'))) {
            $imagePath = request('post_image')->store('uploads', 'public');
            $post->image = $imagePath;
        }

        $saved = $post->save();
        if ($saved) {
            return redirect('/home');
        }        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($postID)
    {
        $delete = Post::where('id', $postID)->first();
        $destinationPath = '/storage/uploads/';
        File::delete($destinationPath . $delete->Image);
        $deleted = Post::where('id', $postID)->delete();

        if ($deleted) {
            return redirect('/home');
        }
    }
}
