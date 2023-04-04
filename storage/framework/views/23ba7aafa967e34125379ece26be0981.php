<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card my-3">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo e($post->user->name); ?></h5>
                        <p class="card-text"><?php echo e($post->body); ?></p>
                        <?php if($post->image): ?>
                            <img src="<?php echo e(asset($post->image)); ?>" alt="<?php echo e($post->user->name); ?> post image" class="img-fluid">
                        <?php endif; ?>
                    </div>
                </div>
                <?php $__currentLoopData = $post->comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card my-3">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted"><?php echo e($comment->user->name); ?></h6>
                            <p class="card-text"><?php echo e($comment->body); ?></p>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <form method="POST" action="<?php echo e(route('comments.store', $post->id)); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label for="body">Leave a comment</label>
                        <input type="hidden" name="post_id" value="<?php echo e($post->id); ?>">
                        <textarea name="body" class="form-control" id="body" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>                
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/gabrielescodinu/Documents/GitHub/social-network/resources/views/posts/show.blade.php ENDPATH**/ ?>