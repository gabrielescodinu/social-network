<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <div class="">
                <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card my-3">
                        <div class="card-body">
                            <img style="width: 300px" src="<?php echo e(asset($post->image)); ?>" alt="<?php echo e($post->user->name); ?>'s post">
                            <h5 class="card-title"><?php echo e($post->user->name); ?></h5>
                            <p class="card-text"><?php echo e($post->body); ?></p>
                            <a href="<?php echo e(route('users.show', $post->user->id)); ?>">Profilo di <?php echo e($post->user->name); ?></a>
                            <br>
                            <div class="btn-group">
                                <?php if(auth()->user()->likes()->where('post_id', $post->id)->exists()): ?>
                                    <button class="btn btn-primary like-button d-none"
                                        data-post-id="<?php echo e($post->id); ?>">Like</button>
                                    <button class="btn btn-danger dislike-button"
                                        data-post-id="<?php echo e($post->id); ?>">Dislike</button>
                                <?php else: ?>
                                    <button class="btn btn-primary like-button"
                                        data-post-id="<?php echo e($post->id); ?>">Like</button>
                                    <button class="btn btn-danger dislike-button d-none"
                                        data-post-id="<?php echo e($post->id); ?>">Dislike</button>
                                <?php endif; ?>
                            </div>
                            <p class="card-text likes"><?php echo e($post->likes()->count()); ?> likes</p>
                            <a href="<?php echo e(route('posts.show', $post->id)); ?>" class="btn btn-primary">View post</a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
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
            $('button[data-post-id="' + postId + '"]').parent().siblings('.likes').text(count + ' likes');
        }

        // Aggiunge un like al post corrispondente
        function addLike(postId) {
            axios.post('/posts/' + postId + '/like', {
                    _token: '<?php echo e(csrf_token()); ?>'
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
                        _token: '<?php echo e(csrf_token()); ?>'
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
                console.log('ciao');

                removeLike(postId);
                $(this).addClass('d-none');
                $(this).siblings('.like-button').removeClass('d-none');
            });
        });
    });
</script>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/gabrielescodinu/Documents/GitHub/social-network/resources/views/posts/explorer.blade.php ENDPATH**/ ?>