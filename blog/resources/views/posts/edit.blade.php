@extends('layouts.app')
@section('title')
    <title>edit</title>
@endsection

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <form method="POST"  action="{{route('posts.update', $post->id )}}">
       @csrf
       @method('PUT')
<div class="mb-3">
   <label for="exampleFormControlInput1" class="form-label">Title</label>
   <input name="title" value="{{$post->title}}" type="text" class="form-control" id="exampleFormControlInput1" >
 </div>
 
 <div class="mb-3">
   <label for="exampleFormControlTextarea1" class="form-label">Description</label>
   <textarea name="description"  class="form-control" id="exampleFormControlTextarea1" rows="3">{{$post->description}}</textarea>
 </div>
 <div class="mb-3">
   <label for="exampleFormControlInput1" class="form-label">Post Creator</label>
<select name="contant_creator"  value="{{$post->user->name}}" class="form-control" >
  
      
   <option @if ($users->id==$post->user_id) selected @endif value="{{$users->id}}">{{$users->name}}</option>
   

</select>

</div>
<button class="btn btn-primary">Update</button>
</form>
@endsection