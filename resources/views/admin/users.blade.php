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
							<div>
								<form CLASS="FORM_ADMIN_USERS" method="POST" action="">
									@csrf
									<div class="row">
										<div class="col-md-3">
											<select xform-class=".FORM_ADMIN_USERS" style="padding: 0px !important;height: 40px !important;font-size: 14px;padding-left: 6px !important;" class="__ADMIN_COUNTRY_USER_FILTER__ form-control browser-default custom-select input-grey" name="country_filter" id="">
												<option value="">Select Country</option>
												<option value="All">All</option>
												<option value="other">Other</option>
												<option value="United States">United States</option>																				
												<option value="United Kingdom">United Kingdom</option>																		
												<option value="Algeria">Algeria</option>																		
												<option value="Argentina">Argentina</option>																		
												<option value="Australia">Australia</option>																		
												<option value="Austria">Austria</option>																		
												<option value="Bahamas">Bahamas</option>																		
												<option value="Barbados">Barbados</option>																		
												<option value="Belgium">Belgium</option>																		
												<option value="Bermuda">Bermuda</option>																		
												<option value="Brazil">Brazil</option>																		
												<option value="Bulgaria">Bulgaria</option>																		
												<option value="Canada">Canada</option>																		
												<option value="Chile">Chile</option>																		
												<option value="China">China</option>																		
												<option value="Cyprus">Cyprus</option>																		
												<option value="Czech">Czech</option>																		
												<option value="Denmark">Denmark</option>																		
												<option value="Dutch">Dutch</option>																		
												<option value="Eastern">Eastern</option>																		
												<option value="Egypt">Egypt</option>																		
												<option value="Fiji">Fiji</option>																		
												<option value="Finland">Finland</option>																		
												<option value="France">France</option>																		
												<option value="Germany">Germany</option>																		
												<option value="Greece">Greece</option>																		
												<option value="Hong Kong">Hong Kong</option>																		
												<option value="Hungary">Hungary</option>																		
												<option value="Iceland">Iceland</option>																		
												<option value="India">India</option>																		
												<option value="Indonesia">Indonesia</option>																		
												<option value="Ireland">Ireland</option>																		
												<option value="Israel">Israel</option>																		
												<option value="Italy">Italy</option>																		
												<option value="Jamaica">Jamaica</option>																		
												<option value="Japan">Japan</option>																		
												<option value="Jordan">Jordan</option>																		
												<option value="Korea (South)">Korea (South)</option>																		
												<option value="Lebanon">Lebanon</option>																		
												<option value="Luxembourg">Luxembourg</option>																		
												<option value="Mexico">Mexico</option>																		
												<option value="Netherlands">Netherlands</option>																		
												<option value="New Zealand">New Zealand</option>																		
												<option value="Norway">Norway</option>																		
												<option value="Pakistan">Pakistan</option>																		
												<option value="Palladium">Palladium</option>																		
												<option value="Philippines">Philippines</option>																		
												<option value="Platinum">Platinum</option>																		
												<option value="Poland">Poland</option>																		
												<option value="Portugal">Portugal</option>																		
												<option value="Romania">Romania</option>																		
												<option value="Russia">Russia</option>																		
												<option value="Saudi Arabia">Saudi Arabia</option>																		
												<option value="Singapore">Singapore</option>																		
												<option value="Slovakia">Slovakia</option>																		
												<option value="South Africa">South Africa</option>																		
												<option value="South Korea">South Korea</option>																		
												<option value="Spain">Spain</option>																		
												<option value="Sudan">Sudan</option>																		
												<option value="Sweden">Sweden</option>																		
												<option value="Switzerland">Switzerland</option>																		
												<option value="Taiwan">Taiwan</option>																		
												<option value="Thailand">Thailand</option>																		
												<option value="Trinidad and Tobago">Trinidad and Tobago</option>																		
												<option value="Turkey">Turkey</option>																		
												<option value="Venezuela">Venezuela</option>																		
												<option value="Zambia">Zambia</option>
											</select>
										</div>
										<div class="col-md-3" style="padding-right: 0px;">
											<input placeholder="Search" class="form-control" type="text" name="search">											
										</div>
										<div class="col-md-2" style="padding-left: 3px;">											
											<button style="" class="btn btn-primary" type="submit">GO</button>										
										</div>
										<div class="col-md-2 offset-2" style="">							
											<span><a href="/admin/users?r=1">Export Users</a> </span>
										</div>
									</div>
								</form>
							</div>
							<br/>
							<div class="table-responsive">
							<table class="table table-striped">
							  <thead>
							    <tr>
									
									<th scope="col">First Name</th>
									<th scope="col">Last Name</th>
									<th scope="col">Email</th>
									<th scope="col">Contact</th>
									<th scope="col">Address</th>
									<th scope="col">Gender</th>
									<th scope="col">Company</th>
									<th scope="col">Birthday</th>
									<th scope="col">Country</th>
									<th scope="col">City</th>
									<th scope="col">Zip</th>
									<th scope="col">Nationality</th>									
							    </tr>
							  </thead>
							  <tbody>
								@if(!$result->isEmpty())

								@foreach  ($result as $item)
									<?php 
									if( $item->first_name !='' and $item->last_name !='' ) 
									{
									?>
										<tr>
																					
											<td>{{$item->first_name}}</td>
											<td>{{$item->last_name}}</td>
											<td>{{$item->email}}</td>
											<td>{{$item->contact}}</td>
											<td>{{$item->address}}</td>
											<td>{{$item->gender}}</td>
											<td>{{$item->company}}</td>
											<td>{{$item->date_birth}}</td>
											<td>{{$item->country}}</td>
											<td>{{$item->city}}</td>
											<td>{{$item->zip}}</td>
											<td>{{$item->nationality}}</td>											
										</tr>	
							 	<?php } ?>	
								@endforeach
								@else 
									<tr>
									<th colspan="6" scope="row">No users available</th>
									
									</tr>	
								@endif
								
							  </tbody>
							</table>
							{{$result->links()}}
							</div>
						</div>
					</div>
			   </div>


		</div>
	
</div>
@endsection

