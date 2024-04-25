<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{
  public function index(Request $request)
  {
    $data=Auth::user();
   
    $postsFromDB = Post::all();

    return view("posts.index", ['posts' => $postsFromDB, 'user'=>$data]);
  }

  public function show(Post $post)
  {

    return view('posts.show', ["post" => $post]);
  }
  public function create(Request $request)
  {
    $singleUser = Auth::user();
    return view('posts.create', ["user" => $singleUser]);

  }
  public function store()
  {
    request()->validate([
      "title" => ["required", "min:3"],
      "description" => ["required", "min:5"],
      "contant_creator" => ['required', 'exists:users,id'],
    ]);

    $data = request()->all();


    $title = request()->title;
    $description = request()->description;
    $UserName = request()->contant_creator;


    $post = new Post();
    $post->title = $title;
    $post->description = $description;
    $post->user_id = $UserName;
    $post->save();

    // $userID=User::table('users')::where('name',$UserName)::from


    return to_route('posts.index');
  }
  public function edit(Post $post,  Request $request)
  {
    $userdata=Auth::user();


    return view('posts.edit', ['users' => $userdata, 'post' => $post]);

  }
  public function update($postID)
  {
    request()->validate([
      "title" => ['required'],
      "description" => ['required'],
      "contant_creator" => ['required', 'exists:users,id']

    ]);

    $title = request("title");
    $description = request("description");
    $UserID = request("contant_creator");

    $singlePostFromDB = Post::findOrFail($postID);

    $singlePostFromDB->update([
      'title' => $title,
      'description' => $description,
      'user_id' => $UserID

    ]);
    return to_route('posts.show', $postID);

  }
  public function destroy($postID)
  {

    $post = Post::findOrFail($postID);
    $post->delete();

    Post::where('id', $postID)->delete();

    return to_route('posts.index');
  }

}
