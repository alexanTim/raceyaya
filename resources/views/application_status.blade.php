@extends('layouts.app')

@section('content')
<div class="container">
	<div class="col-md-12 heading_row">
			<h3>Application Status</h3>
	</div>
</div>
<div class="container application_status_wrapper">
    <div class="row justify-content-center">
	    <div class="col-md-8 application_status" style="">
	    	<div class="inner_" style="margin-top: 18px;margin-left: 24px;margin-right: 24px;">
			    	<div>
				  	 <input type="text" class="form-control application_status_field" placeholder="organizer@gmail.com" style="border-radius: 0px; padding-left: 0px;">
					 </div>
					 <div style="margin-top: 13px;">
				   <button class="btn btn-primary btn-raceyaya-application checkApplicationStatus" style="background:#64c0ff">Submit</button>
				</div>
			</div>
		</div>
		<div class="col-md-8 your_application_status_text" style="margin-top:56px; margin-bottom: 49px;">
			<div class="inner_">
				<h3 style="">Your Application Status:</h3>
				<p class="info_application">
		            In et adiplisicing. easse alipuip duis et cupidatat amet minim. Delore dolore esse eu lorem.Eu exercitation est dolor ullamco est proident commando dolar, pariatur enim aute qui ullmaco.
		        </p> 
	        </div>  
        </div>           
	</div>
</div>
@endsection