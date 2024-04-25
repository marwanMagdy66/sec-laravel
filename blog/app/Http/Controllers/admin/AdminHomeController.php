<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;


class AdminHomeController extends Controller
{
  public function home(Request $request)
  {
    $data=Auth::user();
   
    $postsFromDB = Post::all();

    return view("admin.AdminPosts.home", ['posts' => $postsFromDB, 'user'=>$data]);
  }

  public function show(Post $post)
  {

    return view('admin.AdminPosts.show', ["post" => $post]);
  }
  public function create(Request $request)
  {
    $singleUser = Auth::user();
    return view('admin.AdminPosts.create', ["user" => $singleUser]);

  }
  public function store()
  {
    request()->validate([
      "title" => ["required", "min:3"],
      "description" => ["required", "min:5"],
      "contant_creator" => ['required', 'exists:admins,id'],
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


    return to_route('admin.dashboard.home');
  }
  public function edit(Post $post,  Request $request)
  {
    $userdata=Auth::user();


    return view('admin.AdminPosts.edit', ['users' => $userdata, 'post' => $post]);

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
    return to_route('admin.posts.show', $postID);

  }
  public function destroy($postID)
  {

    $post = Post::findOrFail($postID);
    $post->delete();

    Post::where('id', $postID)->delete();

    return to_route('admin.dashboard.home');
  }

  public function edit_users(Request $request) {
    $allusers = User::all();
    foreach ($allusers as $user) {
        try {
            $user->phone = Crypt::decryptString($user->phone);
            $user->address = Crypt::decryptString($user->address);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            // Log decryption errors
            Log::error('Error decrypting user data: ' . $e->getMessage());
        }
    }


    return view('admin.AdminPosts.editUsers', ['users' => $allusers]);
}
public function delete_users($userId){
// dd($userId);
  

Post::where('user_id', $userId)->delete();


  User::where('id', $userId)->delete();

  return to_route('admin.edit.users');
}

}
