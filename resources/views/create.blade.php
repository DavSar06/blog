@extends('layout/layout')
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

    <h2 class="title d-flex justify-content-center">Publish your blog</h2>
    <form action="{{route('post.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div data-mdb-input-init class="form-outline mb-4">
            <label class="form-label" for="form4Example1">Title</label>
            <input required type="text" name="title" id="form4Example1" class="form-control" />
        </div>
        <div data-mdb-input-init class="form-outline mb-4">
            <label class="form-label" for="form4Example3">Body</label>
            <textarea required class="form-control" name="body" id="form4Example3" rows="4"></textarea>
        </div>

        <div class="mb-3">
            <label for="imageInput" class="form-label">Choose an Image</label>
            <input required class="form-control" type="file" name="image" id="imageInput" accept="image/*">
        </div>
        <div class="mt-3">
            <p class="text-muted">Preview:</p>
            <img id="imagePreview" class="image-preview d-none">
        </div>

        <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block my-4">Publish</button>
    </form>

    <script>
        const imageInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');

        imageInput.addEventListener('change', (event) => {
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = (e) => {
                    imagePreview.src = e.target.result; // Set the preview image
                    imagePreview.classList.remove('d-none'); // Show the image
                };

                reader.readAsDataURL(file); // Read the file as a data URL
            } else {
                imagePreview.src = '';
                imagePreview.classList.add('d-none'); // Hide the image if no file is selected
            }
        });
    </script>
@endsection
