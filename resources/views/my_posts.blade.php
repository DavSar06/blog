@extends('layout/layout')
@section('content')
<div class="row">
    <div class="col-lg-8">
        @foreach($posts as $post)
            <div class="card mb-4">
                <a href="{{route('post.show',$post->id)}}"><img class="card-img-top" src="{{ asset('storage/' . $post->image) }}" alt="..." /></a>
                <div class="card-body">
                    <div class="small text-muted">Posted on {{$post->created_at->format('F j, Y')}} by {{$post->user->name}}</div>
                    <h2 class="card-title">{{$post->title}}</h2>
                    <p class="card-text">{{Str::words($post->body, 30)}}</p>
                    <a class="btn btn-primary" href="{{route('post.show', $post->id)}}">Read more →</a>
                    @if(auth()->id() == $post->user_id)
                        <a class="btn btn-primary" href="{{route('post.edit', $post->id)}}">Edit →</a>
                        <form action="{{route('post.delete', $post->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger">Delete</button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach
        <!-- Pagination-->
        <nav aria-label="Pagination" class="d-flex justify-content-center">
            <hr class="my-0" />
            {{$posts->links()}}
        </nav>
    </div>
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">Search</div>
            <div class="card-body">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Enter search term..." aria-label="Enter search term..." aria-describedby="button-search" />
                    <button class="btn btn-primary" id="button-search" type="button">Go!</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
