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

    /*
     * Ajax Search
     */
    public function search(Request $request)
    {
        $query = $request->get('query');
        $id = auth()->id() == null ? 1 :auth()->id();
        $user = User::query()->find($id);
        $posts = $user->posts()
            ->with('user')
            ->where('title', 'like', '%' . $query . '%')
            ->orWhere('body', 'like', '%' . $query . '%')
            ->orderBy('created_at', 'desc')->get();;

        return response()->json([
            'data' => $posts
        ]);
    }
}
