@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <!-- Mostra i dettagli dell'utente -->
                <h1>{{ $user->name }}</h1>
                @if ($user->image)
                    <img src="{{ asset($user->image) }}" class="img-fluid">
                @endif
                <p>Followers: <span class="followers-count">{{ $user->followers_count }}</span></p>
                <a href="{{ route('users.followers', $user->id) }}">Followers</a>

                <!-- Altri dettagli dell'utente -->
                @if (!auth()->user()->isFollowing($user))
                    <button class="btn btn-primary follow-button" data-user-id="{{ $user->id }}">Follow</button>
                    <button class="btn btn-danger unfollow-button d-none"
                        data-user-id="{{ $user->id }}">Unfollow</button>
                @endif
                @if (auth()->user()->isFollowing($user))
                    <button class="btn btn-primary follow-button d-none" data-user-id="{{ $user->id }}">Follow</button>
                    <button class="btn btn-danger unfollow-button" data-user-id="{{ $user->id }}">Unfollow</button>
                @endif
                <!-- Mostra il pulsante di modifica profilo solo se l'utente corrente è il proprietario del profilo -->
                @if ($user->id == auth()->user()->id)
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit Profile</a>
                @endif
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('.follow-button').click(function() {
            const userId = $(this).data('user-id');
            $.ajax({
                url: '/users/' + userId + '/follow',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log(response);
                    $('.follow-button[data-user-id="' + userId + '"]').addClass('d-none');
                    $('.unfollow-button[data-user-id="' + userId + '"]').removeClass(
                        'd-none');
                    const followersCount = $('.followers-count').text();
                    $('.followers-count').text(parseInt(followersCount) + 1);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });

        $('.unfollow-button').click(function() {
            const userId = $(this).data('user-id');
            $.ajax({
                url: '/users/' + userId + '/unfollow',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log(response);
                    $('.unfollow-button[data-user-id="' + userId + '"]').addClass('d-none');
                    $('.follow-button[data-user-id="' + userId + '"]').removeClass(
                    'd-none');
                    const followersCount = $('.followers-count').text();
                    $('.followers-count').text(parseInt(followersCount) - 1);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });

        function followUser(userId) {
            $.ajax({
                url: '/follow/' + userId,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log(response);
                    // aggiorna la vista del profilo
                    refreshProfileView(userId);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        }
    });
</script>
