<?php $__env->startSection('content'); ?>
<div class="container">
	<div class="row">
		<div class="col-md-12 heading_row">
				<h3>Dashboard</h3>
		</div>
	</div>
</div>
<div class="container">
		<div class="row ">		
			   
			    <div class="col-md-2" style="">
					<?php echo $__env->make('admin.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			   </div>

			   <div class="col-md-10" style="">
			   		
					<div class="row">
						<div class="col-md-12 right-admin-side" style="padding: 20px;border-radius: 5px;margin-top: 18px;">
							
							<div>
								<form class="FORM_ADMIN_BOOSTED_EVENTS" method="POST" action="">
									<?php echo csrf_field(); ?>
									<div class="row">
										<div class="col-md-3">
											<select xform-class=".FORM_ADMIN_BOOSTED_EVENTS" style="padding: 0px !important;height: 40px !important;font-size: 14px;padding-left: 6px !important;" class="__ADMIN_COUNTRY_USER_FILTER__ form-control browser-default custom-select input-grey" name="boosted_filter" id="">
												<option value="" >Select Boost Type</option>
												<option value="1">Boost</option>
												<option value="0">Unboost</option>
											</select>
										</div>
										<div class="col-md-3" style="padding-right: 0px;">
											<input placeholder="Search" class="form-control" type="text" name="search">											
										</div>
										<div class="col-md-2" style="padding-left: 3px;">											
											<button style="" class="btn btn-primary" type="submit">GO</button>
										</div>
									</div>
								</form>
							</div>
							<br/>
							
							<table class="table table-striped">
							  <thead>
							    <tr>							     
							      <th scope="col">Event Name</th>
							      <th scope="col">Email</th>
							      <th scope="col">Event Date</th>
							      <th scope="col">Option</th>							      
							    </tr>
							  </thead>
							  <tbody>
								<?php if(!$results->isEmpty()): ?>
									<?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $values_): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<tr>
											<td><?php echo e($values_->event_name); ?>

												<div><strong>Type:</strong>
												<?php echo ( $values_->is_boost_enable == 1 ) ? '<span style="font-size:12px;color:green;background: green;color: #fff;padding: 3px;display: inline-block;width: 79px;text-align: center;">Boosted</span>' : '<span style="font-size:12px;color:orange;">Unboosted</span>';?></div>
											</td>
											<td><?php echo e($values_->email); ?></td>
											<td><?php echo e($values_->event_date_race); ?></td>
											<td><a href="admin-boost-list?delete=<?php echo e($values_->id); ?>">Delete</a> | <a class="_boost_event_now_" id="<?php echo e($values_->id); ?>" href="javascript:void(0)">Boost</a></td>
										</tr>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php endif; ?>
							  </tbody>
							</table>
<?php echo e($results->links()); ?>


						</div>
					</div>
			   </div>


		</div>
	
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp7.3\htdocs\raceyaya\resources\views/admin/boost.blade.php ENDPATH**/ ?>