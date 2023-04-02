@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card my-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ $post->user->name }}</h5>
                        <p class="card-text">{{ $post->body }}</p>
                        @if ($post->image)
                            <img src="{{ asset($post->image) }}" alt="{{ $post->user->name }} post image" class="img-fluid">
                        @endif
                    </div>
                </div>
                @foreach ($post->comments as $comment)
                    <div class="card my-3">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted">{{ $comment->user->name }}</h6>
                            <p class="card-text">{{ $comment->body }}</p>
                        </div>
                    </div>
                @endforeach
                <form method="POST" action="{{ route('comments.store', $post->id) }}">
                    @csrf
                    <div class="form-group">
                        <label for="body">Leave a comment</label>
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <textarea name="body" class="form-control" id="body" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>                
            </div>
        </div>
    </div>
@endsection
