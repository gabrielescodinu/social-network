@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Followers of {{ $user->name }}</h1>

        <ul>
            @foreach ($user->followers as $follower)
                <a href="{{ route('users.show', $follower->id) }}">{{ $follower->name }}</a>
            @endforeach
        </ul>
    </div>
@endsection
