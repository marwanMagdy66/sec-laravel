<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    use ResponseTrait;
    public function index()
    {

        $post = PostResource::collection(Post::get());
        return $this->apiResponse($post, 'sucess', 200);
    }
    public function show($id)
    {
        $post = Post::find($id);
        if ($post)
            return $this->apiResponse(new PostResource($post), 'sucess', 200);
        else
            return $this->apiResponse(null, 'that not found', 404);
    }
    public function store(Request $request)
    {
        $validate = validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required'
        ]);
        if ($validate->fails()) {
            return $this->apiResponse(null, $validate->errors(), 400);

        }
        $post = Post::create($request->all());
        if ($post)
            return $this->apiResponse(new PostResource($post), 'sucess', 201);
        return $this->apiResponse(null, "not save", 400);

    }
    public function update(Request $request, $id){
        $validate = validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required'
        ]);
        if ($validate->fails()) {
            return $this->apiResponse(null, $validate->errors(), 400);

        }
        $post=Post::find($id);
        if (!$post) {
        return $this->apiResponse(null, "the post not found", 404);

        }
        
        $post->update($request->all());
        if ($post)
            return $this->apiResponse(new PostResource($post), 'the post update', 201);


    }
    public function destroy($id ) {
        $post=Post::find($id);
        if (!$post) {
          return $this->apiResponse(null,'that post not found',404);  
        }
$post->delete();
if($post)
return $this->apiResponse(null,'the post deleted',200);
    }
}
