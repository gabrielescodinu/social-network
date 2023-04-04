<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <!-- Mostra i dettagli dell'utente -->
                <h1><?php echo e($user->name); ?></h1>
                <?php if($user->image): ?>
                    <img src="<?php echo e(asset($user->image)); ?>" class="img-fluid">
                <?php endif; ?>
                <p>Followers: <span class="followers-count"><?php echo e($user->followers_count); ?></span></p>
                <!-- Altri dettagli dell'utente -->
                <?php if(!auth()->user()->isFollowing($user)): ?>
                    <button class="btn btn-primary follow-button" data-user-id="<?php echo e($user->id); ?>">Follow</button>
                    <button class="btn btn-danger unfollow-button d-none"
                        data-user-id="<?php echo e($user->id); ?>">Unfollow</button>
                <?php endif; ?>
                <?php if(auth()->user()->isFollowing($user)): ?>
                    <button class="btn btn-primary follow-button d-none" data-user-id="<?php echo e($user->id); ?>">Follow</button>
                    <button class="btn btn-danger unfollow-button" data-user-id="<?php echo e($user->id); ?>">Unfollow</button>
                <?php endif; ?>
                <!-- Mostra il pulsante di modifica profilo solo se l'utente corrente è il proprietario del profilo -->
                <?php if($user->id == auth()->user()->id): ?>
                    <a href="<?php echo e(route('users.edit', $user->id)); ?>" class="btn btn-primary">Edit Profile</a>
                <?php endif; ?>
            </div>
            <div class="col-md-8">
                <!-- Mostra i post dell'utente -->
                <?php $__currentLoopData = $userPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card">
                        <div class="card-body">
                            <img style="width: 300px" src="<?php echo e(asset($post->image)); ?>" alt="<?php echo e($post->user->name); ?>'s post">
                            <h5 class="card-title"><?php echo e($post->title); ?></h5>
                            <a href="<?php echo e(route('posts.show', $post->id)); ?>" class="btn btn-primary">View post</a>
                            <p class="card-text"><?php echo e($post->body); ?></p>
                            <a href="<?php echo e(route('posts.edit', $post->id)); ?>" class="btn btn-primary">Edit</a>
                            <form method="POST" action="<?php echo e(route('posts.destroy', $post->id)); ?>" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
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
        $('.follow-button').click(function() {
            const userId = $(this).data('user-id');
            $.ajax({
                url: '/users/' + userId + '/follow',
                type: 'POST',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>'
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
                    _token: '<?php echo e(csrf_token()); ?>'
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
                    _token: '<?php echo e(csrf_token()); ?>'
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/gabrielescodinu/Documents/GitHub/social-network/resources/views/users/show.blade.php ENDPATH**/ ?>