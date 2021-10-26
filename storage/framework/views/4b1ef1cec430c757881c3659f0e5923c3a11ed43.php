<?php $__env->startSection('content'); ?>
<div class="container">
	<div class="row">
		<div class="col-md-12 heading_row">
				<h3>Administrator</h3>
		</div>
	</div>
</div>
<div class="container">
		<div class="row ">
			    <div class="col-md-3" style="">
					<ul class="admin_list">
						<li><a style="<?php echo e((request()->is('profile'||'admin')) ? 'color:#fff;background:#37bdf2' : ''); ?>" href="<?php echo e(route('admin')); ?>">Dashboard</a></li>
						<li><a href="<?php echo e(route('admin_users')); ?>">User list</a></li>
						<li><a href="<?php echo e(route('admin_organizer_list')); ?>">Organizer List</a></li>
						<li><a href="<?php echo e(route('admin_boost_list')); ?>">Boost List</a></li>
						<li><a href="<?php echo e(route('admin_signup_list')); ?>">Sign Up List</a></li>
						<li><a href="<?php echo e(route('admin_event_list')); ?>">Event List</a></li>	
						<li><a href="<?php echo e(route('admin_category')); ?>">Category</a></li>				
					</ul>
			   </div>
			   <div class="col-md-9" style="">
			   		<div class="row">
						<div class="col-md-12">Dashboard</div>						
					</div>
					<div class="row">
						<div class="col-md-5" style="padding: 20px;background: #eee;border-radius: 5px;margin-top: 18px;">
							<div class="card border-info mb-3" style="max-width: 18rem;">
								<div class="card-header">Total Pending Signup</div>
								<div class="card-body text-info">
								  <h5 class="card-title"><?php echo $signup_list;?></h5>
								</div>
							  </div>
						</div>
						<div class="col-md-5" style="margin-right:10px;margin-left:10px;padding: 20px;background: #eee;border-radius: 5px;margin-top: 18px;">
							<div class="card border-info mb-3" style="max-width: 18rem;">
								<div class="card-header">Total Racers</div>
								<div class="card-body text-info">
								  <h5 class="card-title"><?php echo $count_users?></h5>
								</div>
							  </div>
						</div>
						<div class="col-md-5" style="padding: 20px;background: #eee;border-radius: 5px;margin-top: 18px;">
							<div class="card border-info mb-3" style="max-width: 18rem;">
								<div class="card-header">Total Organizers</div>
								<div class="card-body text-info">
								  <h5 class="card-title"><?php echo $count_organizers;?></h5>
								</div>
							  </div>
						</div>
						<div class="col-md-5" style="padding: 20px;background: #eee;border-radius: 5px;margin-top: 18px;">
							<div class="card border-info mb-3" style="max-width: 18rem;">
								<div class="card-header">Total Boost Events</div>
								<div class="card-body text-info">
									<h5 class="card-title"><?php echo $count_boost?></h5>
								</div>
							  </div>
						</div>

						<div class="col-md-5" style="padding: 20px;background: #eee;border-radius: 5px;margin-top: 18px;">
							<div class="card border-info mb-3" style="max-width: 18rem;">
								<div class="card-header">Total Active Events</div>
								<div class="card-body text-info">
								  <h5 class="card-title"><?php echo $active_events;?></h5>
								</div>
							  </div>
						</div>
					</div>
			   </div>
		</div>	
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp7.3\htdocs\raceyaya\resources\views/admin.blade.php ENDPATH**/ ?>