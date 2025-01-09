<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function userPosts(){
        $id = auth()->id() == null ? 1 :auth()->id();
        $user = User::query()->find($id);
        $posts = $user->posts()->orderBy('created_at', 'desc')->paginate(10);

        return view('my_posts', ['posts' => $posts]);
    }
}
