<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<style>

.modal-confirm {		
	color: #636363;
	width: 400px;
}
.modal-confirm .modal-content {
	padding: 20px;
	border-radius: 5px;
	border: none;
	text-align: center;
	font-size: 14px;
}
.modal-confirm .modal-header {
	border-bottom: none;   
	position: relative;
}
.modal-confirm h4 {
	text-align: center;
	font-size: 26px;
	margin: 30px 0 -10px;
}
.modal-confirm .close {
	position: absolute;
	top: -5px;
	right: -2px;
}
.modal-confirm .modal-body {
	color: #999;
}
.modal-confirm .modal-footer {
	border: none;
	text-align: center;		
	border-radius: 5px;
	font-size: 13px;
	padding: 10px 15px 25px;
} 
.modal-confirm .modal-footer a {
	color: #fff;
}		
.modal-confirm .icon-box {
	width: 80px;
	height: 80px;
	margin: 0 auto;
	border-radius: 50%;
	z-index: 9;
	text-align: center;
	border: 3px solid #f15e5e;
}
.modal-confirm .icon-box i {
	color: #f15e5e;
	font-size: 46px;
	display: inline-block;
	margin-top: 13px;
}
.modal-confirm .btn, .modal-confirm .btn:active {
	color: #fff;
	border-radius: 4px;
	background: #60c7c1;
	text-decoration: none;
	transition: all 0.4s;
	line-height: normal;
	min-width: 120px;
	border: none;
	min-height: 40px;
	border-radius: 3px;
	margin: 0 5px;
}
.modal-confirm .btn-secondary {
	background: #c1c1c1;
}
.modal-confirm .btn-secondary:hover, .modal-confirm .btn-secondary:focus {
	background: #a8a8a8;
}
.modal-confirm .btn-danger {
	background: #f15e5e;
	
}
.modal-confirm .btn-danger:hover, .modal-confirm .btn-danger:focus {
	background: #ee3535;
}
.modal-footer a{
color:white;
}

</style>

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
                        <a style="display:inline-block;margin-bottom:12px" href="<?php echo e(route('new_cat')); ?>">New category</a>
						   
						<div>
							<form  method="POST" action="">
								<?php echo csrf_field(); ?>
								<div class="row">
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
						
							<br/>
							<table class="table table-striped">
							  <thead>
							    <tr>
							      
							      <th scope="col">Name</th>
							      <th scope="col">Created</th>
							      <th scope="col">Option</th>							      
							    </tr>
							  </thead>
							  <tbody>
								<?php if(!$result->isEmpty()): ?>
								<?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<tr>
                                        <td><?php echo e($item->name); ?></td>
										<td><?php echo e($item->created_at); ?></td>	
										
								<!-- 	edit modal -->



							<div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">EDIT</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
       

      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-primary">Confirm</button>
      </div>
    </div>
  </div>
</div>

									<!--edit modal -->
																	
									<td> <a href=""data-toggle="modal" data-target="#modalLoginForm">Edit</a>&nbsp;|&nbsp;
									<a href="#myModal" class="trigger-btn" data-toggle="modal">Delete</a>
									<!-- a href="<?php echo e(route('new_cat')); ?>?action=edit&id=<?php echo e($item->id); ?>"> -->
								<!-- Modal HTML -->
								<div id="myModal" class="modal fade">
									<div class="modal-dialog modal-confirm">
										<div class="modal-content">
											<div class="modal-header flex-column">
												<div class="icon-box">
													<i class="material-icons">&#xE5CD;</i>
													</div>						
														<h4 class="modal-title w-100">Are you sure?</h4>	
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													</div>
													<div class="modal-body">
														<p>Do you really want to delete this records? This process cannot be undone.</p>
													</div>
													<div class="modal-footer justify-content-center">
														<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
														<a class="btn btn-danger" href="<?php echo e(route('admin_category')); ?>?action=delete&id=<?php echo e($item->id); ?>">Delete</a>
													</div>
												</div>
											</div>
										</td>
									</tr>	
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php else: ?> 
									<tr>
									<th colspan="6" scope="row">No category available</th>
									
									</tr>	
								<?php endif; ?>
								
							  </tbody>
							</table>
							<?php echo e($result->links()); ?>


						</div>
					</div>
			   </div>


		</div>
	
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp7.3\htdocs\raceyaya\resources\views/admin/category.blade.php ENDPATH**/ ?>