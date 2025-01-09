@extends('layout/layout')
@section('content')
<article>
    <!-- Control buttons-->
    @if(auth()->id() == $post->user_id)
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a class="btn btn-outline-warning" href="{{route('post.edit', $post->id)}}">Edit →</a>
        <form action="{{route('post.delete', $post->id)}}" method="POST">
            @csrf
            @method('DELETE')
            <button class="btn btn-outline-danger">Delete</button>
        </form>
    </div>
    @endif
    <!-- Post header-->
    <header class="mb-4">
        <h1 class="fw-bolder mb-1">{{$post->title}}</h1>
        <div class="text-muted fst-italic mb-2">Posted on {{$post->created_at->format('F j, Y')}} by {{$post->user->name}}</div>
    </header>
    <!-- Preview image figure-->
    <figure class="mb-4"><img class="img-fluid rounded" src="{{ asset('storage/' . $post->image) }}" alt="..." /></figure>
    <!-- Post content-->
    <section class="mb-5">
        <p class="fs-5 mb-4">{{$post->body}}</p>
    </section>
</article>
@endsection
