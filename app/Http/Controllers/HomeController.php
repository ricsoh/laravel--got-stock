<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use App\Models\Post;
use App\Models\Category;
use illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // => ME, switch to different home page pending on user role
        $user = Auth::user();
        // Get all data from DB
        $users = \App\Models\user::all();
        $profiles = \App\Models\profile::all();
        $posts = \App\Models\post::all();
        $categories = \App\Models\category::all();
        // => ME, switch to different home page base on role
        switch($user->role){
            case 'admin':
                // => ME, need to pass array here
                return view('admin_home', [
                    'users' => $users,
                    'profiles' => $profiles,
                    'posts' => $posts,
                    'categories' => $categories]);
                break;
            case 'shop':
                // => ME, need to pass array here
                return view('shop_home', [
                    'users' => $users,
                    'profiles' => $profiles,
                    'posts' => $posts,
                    'categories' => $categories]);
                break;
            case NULL:
                // => ME, need to pass array here
                return view('home', [
                    'profiles' => $profiles,
                    'posts' => $posts,
                    'categories' => $categories]);
                break;
            default:
                return view('welcome');
        }
    }

    // 
    public function postCreate(Request $request)
    {
        //
    }

    // => ME, for editing user table
    public function postEdit(Request $request)
    {
        $data = request()->validate([
            'user_id' => 'required',
            'user_role' => 'required',
        ]);
    
        $userID = request('user_id');
        $user = User::find($userID); // This is for updating selected ID

        $user->id = request('user_id');
        $user->name = request('user_name');
        $user->email = request('user_email');
        $userRole = request('user_role');
        if($userRole == 'NULL'){
            $userRole = NULL;
        }
        $user->role = $userRole;

        $saved = $user->save();
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
    // ME=>, Delete user... need to delete from profile and post
    public function destroy(Request $request)
    {
        $userID = request('user_id');

        // delete user from user table
        $delete = User::where('id', $userID)->first();
        $deletedUser = User::where('id', $userID)->delete();
        // delete user's profile from profile table
        $delete = Profile::where('user_id', $userID)->first();
        $deletedProfile = Profile::where('user_id', $userID)->delete();
        // delete user's post from post table
        $delete = Post::where('user_id', $userID)->first();
        $deletedPost = Post::where('user_id', $userID)->delete();

        if ($deletedUser && $deletedProfile) {
            return redirect('/home');
        }
    }

}

