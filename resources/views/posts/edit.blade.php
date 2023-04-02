@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card my-3">
                    <div class="card-body">
                        <form method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label for="body">Edit post</label>
                                <textarea name="body" class="form-control" id="body" rows="3" required>{{ $post->body }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" class="form-control-file" name="image" id="image">
                            </div>
                            @if ($post->image)
                                <div class="form-group">
                                    <label>Current Image</label><br>
                                    <img src="{{ asset($post->image) }}" alt="current image" width="150">
                                </div>
                            @endif
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
