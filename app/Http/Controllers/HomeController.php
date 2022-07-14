<?php

namespace App\Http\Controllers;

use App\Posts;
use App\User;
use HttpOz\Roles\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();
        $posts = Posts::get()->count();
        if($user->hasRole('admin')){
            $admin = Role::findBySlug('admin')->users->count();
            $supervisors = Role::findBySlug('supervisor')->users->count();
            $blogger = Role::findBySlug('blogger')->users->count();
            return view('home', [
                'user' =>$user,
                'post' =>$posts,
                'admins' =>$admin,
                'supervisors' =>$supervisors,
                'bloggers' =>$blogger,
            ]);
        }
        return view('home', [
            'user' =>$user,
            'post' =>$posts
        ]);
    }
}
