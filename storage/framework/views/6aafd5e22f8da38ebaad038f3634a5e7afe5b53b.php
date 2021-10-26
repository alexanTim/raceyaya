<ul class="admin_list">
    <li><a href="<?php echo e(route('admin')); ?>">Dashboard</a></li>
    <?php if(Route::currentRouteName() == 'admin_users'): ?>						
         <li><a style="color:#fff;background:#37bdf2" href="<?php echo e(route('admin_users')); ?>">User list</a></li>
    <?php else: ?> 
        <li><a href="<?php echo e(route('admin_users')); ?>">User list</a></li>
    <?php endif; ?>
    
    <?php if(Route::currentRouteName() == 'admin_organizer_list'): ?>						
         <li><a style="color:#fff;background:#37bdf2" href="<?php echo e(route('admin_organizer_list')); ?>">Organizer List</a></li>
    <?php else: ?> 
         <li><a href="<?php echo e(route('admin_organizer_list')); ?>">Organizer List</a></li>
    <?php endif; ?>
    
    <?php if(Route::currentRouteName() == 'admin_boost_list'): ?>						
         <li><a style="color:#fff;background:#37bdf2" href="<?php echo e(route('admin_boost_list')); ?>">Boost List</a></li>
    <?php else: ?> 
         <li><a href="<?php echo e(route('admin_boost_list')); ?>">Boost List</a></li>
    <?php endif; ?>
    
    <?php if(Route::currentRouteName() == 'admin_signup_list'): ?>						
         <li><a style="color:#fff;background:#37bdf2;" href="<?php echo e(route('admin_signup_list')); ?>">Sign Up List</a></li>
    <?php else: ?> 
         <li><a href="<?php echo e(route('admin_signup_list')); ?>">Sign Up List</a></li>
    <?php endif; ?>
    
    <?php if(Route::currentRouteName() == 'admin_event_list'): ?>						
         <li><a style="color:#fff;background:#37bdf2;" href="<?php echo e(route('admin_event_list')); ?>">Event List</a></li>
    <?php else: ?> 
         <li><a href="<?php echo e(route('admin_event_list')); ?>">Event List</a></li>
    <?php endif; ?>
	
	<?php if(Route::currentRouteName() == 'admin_category'): ?>						
         <li><a style="color:#fff;background:#37bdf2;" href="<?php echo e(route('admin_category')); ?>">Category</a></li>
    <?php else: ?> 
         <li><a href="<?php echo e(route('admin_category')); ?>">Category</a></li>
    <?php endif; ?>
</ul><?php /**PATH E:\xampp7.3\htdocs\raceyaya\resources\views/admin/menu.blade.php ENDPATH**/ ?>