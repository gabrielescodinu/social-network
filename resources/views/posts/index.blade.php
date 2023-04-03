@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @foreach ($posts as $post)
                    <div class="card my-3">
                        <div class="card-body">
                            <img style="width: 300px" src="{{ asset($post->image) }}" alt="{{ $post->user->name }}'s post">
                            <h5 class="card-title">{{ $post->user->name }}</h5>
                            <p class="card-text">{{ $post->body }}</p>
                            <a href="{{ route('users.show', $post->user->id) }}">Profilo di {{ $post->user->name }}</a>
                            <br>
                            <div class="btn-group">
                                @if (auth()->user()->likes()->where('post_id', $post->id)->exists())
                                    <button class="btn btn-primary like-button d-none"
                                        data-post-id="{{ $post->id }}">Like</button>
                                    <button class="btn btn-danger dislike-button"
                                        data-post-id="{{ $post->id }}">Dislike</button>
                                @else
                                    <button class="btn btn-primary like-button"
                                        data-post-id="{{ $post->id }}">Like</button>
                                    <button class="btn btn-danger dislike-button d-none"
                                        data-post-id="{{ $post->id }}">Dislike</button>
                                @endif
                            </div>
                            <p class="card-text">{{ $post->likes()->count() }} likes</p>
                            <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary">View post</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-md-4">
                <div class="card my-3">
                    <div class="card-body">
                        <a href="{{ route('posts.create') }}" class="btn btn-primary btn-block">Create a new post</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Aggiorna il conteggio dei likes per un determinato post
        function updateLikeCount(postId, count) {
            $('button[data-post-id="' + postId + '"]').parent().siblings('.card-text').text(count + ' likes');
        }

        // Aggiunge un like al post corrispondente
        function addLike(postId) {
            axios.post('/posts/' + postId + '/like', {
                    _token: '{{ csrf_token() }}'
                })
                .then(response => {
                    console.log(response.data);
                    updateLikeCount(postId, response.data.total_likes);
                })
                .catch(error => {
                    console.log(error);
                });
        }

        // Rimuove un like dal post corrispondente
        function removeLike(postId) {
            axios.delete('/posts/' + postId + '/dislike', {
                    data: {
                        _token: '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    console.log(response.data);
                    updateLikeCount(postId, response.data.total_likes);
                })
                .catch(error => {
                    console.log(error);
                });
        }

        // Aggiunge un gestore di eventi per il clic sui bottoni "Like" e "Dislike"
        $('.like-button').each(function() {
            const postId = $(this).data('post-id');

            $(this).click(function() {
                addLike(postId);
                $(this).addClass('d-none');
                $(this).siblings('.dislike-button').removeClass('d-none');
                console.log('Like button clicked');
            });
        });

        $('.dislike-button').each(function() {
            const postId = $(this).data('post-id');

            $(this).click(function() {
                removeLike(postId);
                $(this).addClass('d-none');
                $(this).siblings('.like-button').removeClass('d-none');
            });
        });
    });
</script>
