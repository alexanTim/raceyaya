@extends('layouts.app')

@section('content')
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
					@include('admin.menu')
			   </div>

			   <div class="col-md-10" style="">
			   						<div class="row">
						<div class="col-md-12 right-admin-side" style="padding: 20px;border-radius: 5px;margin-top: 18px;">
                            
                            <form action="" method="post">

								<?php 									
									if(isset($_GET['action'])=='edit' && !empty($_GET['action'])){
										$id = $_GET['id'];
										echo '<input type="hidden" name="mode" value="edit"/>';
										echo '<input type="hidden" name="id" value="'.$id.'"/>';
									}	else{
										echo '<input type="hidden" name="mode" value="create"/>';
									}
								?>


								@csrf	
                                <div class="form-group">
                                    <label for="Category_name">Category Name</label>
                                    <input style="width:30%" value="<?php echo $category_name;?>" id="Category_name" class="Category_name form-control" name="category_name" type="text">
                                </div>
                                <div class="form-group">
                                   <button class="btn btn-primary" name="save_category" type="submit">Save</button>
                                </div>
                            </form>

						</div>
					</div>
			   </div>


		</div>
	
</div>
@endsection

