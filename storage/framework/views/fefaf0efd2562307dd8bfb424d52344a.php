<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card my-3">
                        <div class="card-body">
                            <img style="width: 300px" src="<?php echo e(asset($post->image)); ?>" alt="<?php echo e($post->user->name); ?>'s post">
                            <h5 class="card-title"><?php echo e($post->user->name); ?></h5>
                            <p class="card-text"><?php echo e($post->body); ?></p>
                            <div class="btn-group">
                                <button class="btn btn-primary like-button" data-post-id="<?php echo e($post->id); ?>">Like</button>
                                <button class="btn btn-danger dislike-button"
                                    data-post-id="<?php echo e($post->id); ?>">Dislike</button>
                            </div>
                            <p class="card-text"><?php echo e($post->likes()->count()); ?> likes</p>
                            <a href="<?php echo e(route('posts.show', $post->id)); ?>" class="btn btn-primary">View post</a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="col-md-4">
                <div class="card my-3">
                    <div class="card-body">
                        <a href="<?php echo e(route('posts.create')); ?>" class="btn btn-primary btn-block">Create a new post</a>
                    </div>
                </div>
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
        // Aggiunge un like al post corrispondente
        function addLike(postId) {
            $.ajax({
                url: '/posts/' + postId + '/like',
                type: 'POST',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>'
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
                        _token: '<?php echo e(csrf_token()); ?>'
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/gabrielescodinu/Documents/GitHub/social-network/resources/views/posts/index.blade.php ENDPATH**/ ?>