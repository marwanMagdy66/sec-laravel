@extends('admin.layouts.app')

@section('content')



<div>
    @yield('title')
  <title>index</title>
  </div>
       
        
        {{-- <div class="mt-5">
          <div class="text-center">
              <a type="button" class="btn btn-success" href={{route("admin.posts.create")}} >Create Post</a>
  
          </div>
        </div> --}}

        <div class="mt-2">
          <div class="text-center">
              <a type="button"  class="btn btn-primary" href={{route("admin.edit.users")}} >Modify Users </a>
  
          </div>
        </div>
  
        <div class="mt-4 ">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Posted By</th>
                <th scope="col">Created At</th>
                <th scope="col">Actions</th>
    
              </tr>
            </thead>
            <tbody>
            
                @foreach( $posts as $post )
                <tr>
                    <th scope="row">{{$post->id}}</th>
                    <td>{{$post->title}}</td>
                    <td>{{$post->user->name}}</td>
                    <td>{{$post->created_at->format("y-m-d")}}</td>
                    <td>
                    
                        <a href={{route('admin.posts.show',$post->id)}} class="btn btn-info">View</a>
                        {{-- <a href="{{route('admin.posts.edit',$post->id)}}" class="btn btn-primary">Edit</a> --}}
                        <form style="display: inline;" method="POST" action="{{route('admin.posts.destroy', $post->id)}}">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger">Delete</button>
                      </form>
                      </td>
                    
        
                  </tr>
                @endforeach
            
          
            
            </tbody>
          </table>
      </div>
    


@endsection