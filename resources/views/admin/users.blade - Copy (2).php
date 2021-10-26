@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12 heading_row">
				<h3>Administrator</h3>
		</div>
	</div>
</div>
<div class="container">
		<div class="row ">		
			   
			    <div class="col-md-2" style="">
					<ul class="admin_list">
						<li><a href="{{ route('admin_my_profile') }}">My Profile</a></li>
						<li><a href="{{ route('admin_users') }}">User list</a></li>
						<li><a href="{{ route('admin_organizer_list') }}">Organizer List</a></li>
						<li><a href="{{ route('admin_boost_list') }}">Boost List</a></li>
						<li><a href="{{ route('admin_signup_list') }}">Sign Up List</a></li>
						<li><a href="{{ route('admin_event_list') }}">Event List</a></li>				
					</ul>
			   </div>

			   <div class="col-md-10" style="">
			   		<div class="row">
						<div class="col-md-12">My Profile</div>
						
					</div>

					<div class="row">
						<div class="col-md-12 right-admin-side" style="padding: 20px;border-radius: 5px;margin-top: 18px;">
							
							<table class="table table-striped">
							  <thead>
							    <tr>
							      <th scope="col">ID</th>
							      <th scope="col">Name</th>
							      <th scope="col">Gender</th>
							      <th scope="col">Birthday</th>
							       <th scope="col">Country</th>
							    </tr>
							  </thead>
							  <tbody>
							    <tr>
							      <th scope="row">1</th>
							      <td>Mark</td>
							      <td>Otto</td>
							      <td>@mdo</td> <td>@mdo</td>
							    </tr>
							    <tr>
							      <th scope="row">2</th>
							      <td>Jacob</td>
							      <td>Thornton</td>
							      <td>@fat</td> <td>@mdo</td>
							    </tr>
							    <tr>
							      <th scope="row">3</th>
							      <td>Larry</td>
							      <td>the Bird</td>
							      <td>@twitter</td> <td>@mdo</td>
							    </tr>
							  </tbody>
							</table>


						</div>
					</div>
			   </div>


		</div>
	
</div>
@endsection

