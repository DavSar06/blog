@extends('layout/layout')
@section('content')
    <div class="row">
        <div class="col-lg-8">
            <!-- Search Results will be rendered here -->
            <div id="search-results">
                @foreach($posts as $post)
                    <div class="card mb-4">
                        <a href="{{route('post.show', $post->id)}}"><img class="card-img-top" src="{{ asset('storage/' . $post->image) }}" alt="..." /></a>
                        <div class="card-body">
                            <div class="small text-muted">Posted on {{$post->created_at->format('F j, Y')}} by {{$post->user->name}}</div>
                            <h2 class="card-title">{{$post->title}}</h2>
                            <p class="card-text">{{Str::words($post->body, 30)}}</p>
                            <div class="d-flex">
                                <a class="btn me-2 btn-primary" href="{{route('post.show', $post->id)}}">Read more →</a>
                                @if(auth()->id() == $post->user_id)
                                    <a class="btn me-2 btn-primary" href="{{route('post.edit', $post->id)}}">Edit →</a>
                                    <form action="{{route('post.delete', $post->id)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination links (will be updated dynamically) -->
            <div id="pagination-links">
                {{ $posts->links() }}
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">Search</div>
                <div class="card-body">
                    <div class="input-group">
                        <input class="form-control" id="search" type="text" placeholder="Enter search term..." aria-label="Enter search term..." aria-describedby="button-search" />
                        <button class="btn btn-primary" id="button-search" type="button">Go!</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#button-search').on('click', function() {
                var query = $('#search').val();
                if(query.length > 2) {
                    $.ajax({
                        url: "{{ route('search') }}",
                        method: "GET",
                        data: { query: query },
                        success: function(data) {
                            var results = '';

                            // Ensure 'data.data' is defined and is an array
                            if (data && data.data && Array.isArray(data.data) && data.data.length > 0) {
                                data.data.forEach(function(post) {
                                    // Format the date as "Month Day, Year"
                                    var date = new Date(post.created_at);
                                    var formattedDate = date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });

                                    // Check if 'user' exists before accessing 'name'
                                    var userName = post.user && post.user.name ? post.user.name : 'Unknown User';

                                    // Generate the post's card HTML
                                    results += '<div class="card mb-4"><a href="/post/' + post.id + '"><img class="card-img-top" src="/storage/' + post.image + '" alt="..."></a><div class="card-body"><div class="small text-muted">Posted on ' + formattedDate + ' by ' + userName + '</div><h2 class="card-title">' + post.title + '</h2><p class="card-text">' + post.body.slice(0, 100) + '...</p><div class="d-flex"><a class="btn me-2 btn-primary" href="/post/' + post.id + '">Read more →</a>';

                                    // Add Edit and Delete buttons for the post owner
                                    if(post.user_id === {{ auth()->id() }}) {
                                        results += '<a class="btn me-2 btn-primary" href="/post/' + post.id + '/edit">Edit →</a>' +
                                            '<form action="/post/' + post.id + '/delete" method="POST" style="display:inline;">' +
                                            '@csrf @method("DELETE")' +
                                            '<button class="btn btn-outline-danger">Delete</button>' +
                                            '</form>';
                                    }

                                    results += '</div></div></div>';
                                });
                            } else {
                                results = '<p>No results found.</p>';
                            }
                            $('#search-results').html(results); // Insert results into the search-results div
                        },
                        error: function(xhr, status, error) {
                            console.error("Error:", error);
                        }
                    });
                }
            });
        });
    </script>
@endsection
