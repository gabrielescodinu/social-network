<?php $__env->startSection('content'); ?>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header"><?php echo e(__('Messages')); ?></div>

          <div class="card-body">
            <message-tabs :users="<?php echo e($users); ?>" :messages="<?php echo e($messages); ?>"></message-tabs>
          </div>

          <div class="card-footer">
            <h4><?php echo e(__('New Message')); ?></h4>
            <form action="<?php echo e(route('messages.store')); ?>" method="post">
              <?php echo csrf_field(); ?>

              <div class="form-group">
                <label for="recipient"><?php echo e(__('Recipient')); ?></label>
                <select name="recipient_id" id="recipient" class="form-control" required>
                  <option value=""><?php echo e(__('Select a recipient')); ?></option>
                  <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>

              <div class="form-group">
                <label for="subject"><?php echo e(__('Subject')); ?></label>
                <input type="text" name="subject" id="subject" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="body"><?php echo e(__('Message')); ?></label>
                <textarea name="body" id="body" cols="30" rows="10" class="form-control" required></textarea>
              </div>

              <div class="form-group">
                <button type="submit" class="btn btn-primary"><?php echo e(__('Send')); ?></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
  <script src="<?php echo e(asset('js/app.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/gabrielescodinu/Documents/GitHub/social-network/resources/views/messages/index.blade.php ENDPATH**/ ?>