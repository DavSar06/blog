<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .image-preview {
            width: 100%; /* Ensures the image fits the container width */
            height: auto;
            border: 1px solid #ddd; /* Optional border */
            border-radius: 5px;
            object-fit: cover; /* Ensures proper scaling */
        }
        .active .page-link {
            background-color: #1a202c;
            border: none;
        }
        .pagination {
            color: black;
        }
        .page-item a {
            color: black;
        }
    </style>
    <title>Home</title>
</head>
<body>
<div class="navbar-light bg-light">
    <div class="container">
        <div class="navbar navbar-light navbar-expand-sm justify-content-between">
            <a href="{{route('dashboard')}}" class="navbar-brand mb-0 h1">Blog</a>
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a href="{{route('dashboard')}}" class="nav-link active">Home</a>
                </li>
                @auth()
                <li class="nav-item active">
                    <a href="{{route('post.create')}}" class="nav-link">Create Post</a>
                </li>

                <li class="nav-item active dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{auth()->user()->name}}</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li>
                            <a href="{{route('userPosts')}}" class="dropdown-item">My Page</a>
                        </li>
                        <li>
                            <form action="{{route('logout')}}" method="POST">
                                @csrf
                                <button class="dropdown-item">Log Out</button>
                            </form>
                        </li>
                    </ul>
                </li>
                @else
                <li class="nav-item active">
                    <a href="{{route('login')}}" class="nav-link">Login</a>
                </li>
                <li class="nav-item active">
                    <a href="{{route('register')}}" class="nav-link">Register</a>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</div>

<div class="container px-5 mt-3" style="min-height: 600px">
    <div class="container">
        @yield('content')
    </div>
</div>

<footer class="py-5 bg-dark">
    <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2025</p></div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
