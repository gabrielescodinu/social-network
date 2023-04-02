<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-4">
            <!-- Mostra i dettagli dell'utente -->
            <h1><?php echo e($user->name); ?></h1>
            <img src="<?php echo e($user->profile_image); ?>" alt="Profile Image">
            <!-- Altri dettagli dell'utente -->
        </div>
        <div class="col-md-8">
            <!-- Mostra i post dell'utente -->
            <?php $__currentLoopData = $userPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card">
                    <div class="card-body">
                        <img style="width: 300px" src="<?php echo e(asset($post->image)); ?>" alt="<?php echo e($post->user->name); ?>'s post">
                        <h5 class="card-title"><?php echo e($post->title); ?></h5>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/gabrielescodinu/Documents/GitHub/social-network/resources/views/users/show.blade.php ENDPATH**/ ?>