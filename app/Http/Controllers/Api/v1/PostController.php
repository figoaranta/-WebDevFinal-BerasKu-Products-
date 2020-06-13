<?php

namespace App\Http\Controllers\Api\v1;
use App\Post;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostResourceCollection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show(Post $post):PostResource
    {
    	return new PostResource($post);
    }

    public function index():PostResourceCollection
    {
    	return new PostResourceCollection(Post::paginate());
    }

    public function update(Request $request, Post $post)
    {

    	$post->update($request->all());
    	return new PostResource($post);
    }

    public function destroy(Post $post)
    {

        if($post->userId != $user->id){
            return response()->json(['error'=> "Unable to delete other user's post"]);
        }
    	$post->delete();
    	return response()->json([]);
    } 

    public function self()
    {
 
        $post = Post::where('userId',$user->id)->first();
        return $post;
    } 

    public function store(Request $request)
    {
        $request->validate([
            'userId' => 'required',
            'productId' => 'required',
            'postTitle' => 'required',
            'postDescription' =>'required'
        ]);
 
        $post = post::create($request->all());
        return new PostResource($post);
    }
    public function search(Request $request)
    {
        $request->validate([
            "input" => "required",
        ]);
        $postsArray = [];
        $posts = Post::where('postTitle','like','%'.$request->input.'%')->get();
        foreach ($posts as $post) {
            array_push($postsArray,$post);
        }
        return response()->json(["data"=>$postsArray]);
    }
    
}









