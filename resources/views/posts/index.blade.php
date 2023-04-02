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
                            <div class="btn-group">
                                <button class="btn btn-primary like-button" data-post-id="{{ $post->id }}">Like</button>
                                <button class="btn btn-danger dislike-button"
                                    data-post-id="{{ $post->id }}">Dislike</button>
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
        // Aggiunge un like al post corrispondente
        function addLike(postId) {
            $.ajax({
                url: '/posts/' + postId + '/like',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
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
                console.log('Like button clicked');
            });
        });

        $('.dislike-button').each(function() {
            const postId = $(this).data('post-id');

            $(this).click(function() {
                removeLike(postId);
            });
        });
    });
</script>
