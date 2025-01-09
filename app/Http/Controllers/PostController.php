<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    /*
     * Displaying All Posts On Home Page
     */
    public function index(){
        $posts = Post::query()->orderBy('created_at', 'desc')->paginate(10);
        return view('home', ['posts' => $posts]);
    }

    /*
     * Create Post Page
     */
    public function showCreatePage(){
        return view('create');
    }

    /*
     * Uploading Post
     */
    public function create(Request $request){
        if(!auth()->check()){
            dump(403);
        }
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('posts', 'public'); // Save to storage/app/public/posts
        }

        $post = Post::create([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'user_id' => auth()->id(),
            'image' => $imagePath,
            'created_at' => now()
        ]);

        return redirect()->route('post.show',$post->id);
    }

    /*
     * Showing Post Information
     */
    public function read($id){
        $post = Post::query()->findOrFail($id);
        return view('post', ['post' => $post]);
    }

    /*
     * Editing Post Page
     */
    public function edit($id){
        $post = Post::findOrFail($id);
        if(auth()->id() != $post->user_id){
            dump(403);
        }
        return view('edit', ['post' => $post]);
    }

    /*
     * Updating Post In Database
     */
    public function update($id, Request $request){
        // Validate the input
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Find the post by ID
        $post = Post::findOrFail($id);

        if(!auth()->check() && $post->user_id != auth()->id()){
            dump(403);
        }

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($post->image && \Storage::disk('public')->exists($post->image)) {
                \Storage::disk('public')->delete($post->image);
            }

            // Upload the new image
            $imagePath = $request->file('image')->store('posts', 'public');
            $post->image = $imagePath;
        }

        // Update the other fields
        $post->title = $request->input('title');
        $post->body = $request->input('body');

        // Save the updated post
        $post->save();

        // To the page of that post
        return redirect()->route('post.show',$post->id);
    }

    /*
     * Delete Post
     */
    public function delete($id){
        $post = Post::findOrFail($id);

        if(!auth()->check() || auth()->id() != $post->user_id){
            dump(403);
        }

        // Delete the image file if it exists
        if ($post->image && \Storage::disk('public')->exists($post->image)) {
            \Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        // Return back to home page
        $posts = Post::query()->orderBy('created_at', 'desc')->paginate(10);
        return view('home', ['posts' => $posts]);
    }

    /*
     * Ajax Search
     */
    public function search(Request $request)
    {
        $query = $request->get('query');
        $posts = Post::with('user')
            ->where('title', 'like', '%' . $query . '%')
            ->orWhere('body', 'like', '%' . $query . '%')
            ->get();

        return response()->json([
            'data' => $posts
        ]);
    }
}
