@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <!-- Mostra i dettagli dell'utente -->
                <h1>{{ $user->name }}</h1>
                <img src="{{ $user->profile_image }}" alt="Profile Image">
                <!-- Altri dettagli dell'utente -->
            </div>
            <div class="col-md-8">
                <!-- Mostra i post dell'utente -->
                @foreach ($userPosts as $post)
                    <div class="card">
                        <div class="card-body">
                            <img style="width: 300px" src="{{ asset($post->image) }}" alt="{{ $post->user->name }}'s post">
                            <h5 class="card-title">{{ $post->title }}</h5>
                            <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary">View post</a>
                            <p class="card-text">{{ $post->body }}</p>
                            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary">Edit</a>
                            <form method="POST" action="{{ route('posts.destroy', $post->id) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
