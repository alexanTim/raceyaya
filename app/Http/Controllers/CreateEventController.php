<?php
/**
 *   Author: alexander Timbal
 *   Email: touchmealex@gmail.com
 *   Website: snipre.com
 */
namespace App\Http\Controllers;
use  App\User;
use  DB;
use  Illuminate\Http\Request;
use  Illuminate\Support\Facades\Auth;
use  App\Classes\dog;
use  App\Classesss\Validate;
use  App\Classesss\Event;

class CreateEventController extends Controller
{
	private  $currency_symbol = '';
	private  $current_cat_id = 0;
	private  $current_cat_currency = '&#8369;';
	private  $shop_sign = '';
	private  $message_registration_approved = 'Payment Completed';
	private  $message_registration_pending = 'Payment Pending';
	private  $this_url = '';

	public function __construct()
    {
        $this->this_url =  url('/');
    }

	/**
	 *  CREATE EVENT ORGANIZER USER TYPE
	 */
	public function index(){
			 $country = DB::table("tbl_country")->get();

			 $user_country = Auth::user();
             if($user_country->user_type != 2){
				 return redirect('/profile');
			 }
			 $user_country = $user_country->country;
			 $tbl_admin_category = new Event();
			 $sports_category_list = $tbl_admin_category->getCategorySports();

			 return view('organizer.create' ,compact('country','user_country','sports_category_list'));
	}

	/**
	 *  EDITING EVENT @PARAM = EVENT ID
	 */
	public function editView($id){
			$user = Auth::user();
			$result = DB::table("tbl_organizer_event")->where('id',$id)->where('user_id',$user->id)->get();
			$event_id = $id;
			$user_country = Auth::user();

			//ADDED ALEX WILL CHECK IF ORGANIZER IS EXIST WITH THE CURRENT
			//LOGGED USER THEN REDIRECT TO PROFILE
			if($result->isEmpty()){
				return redirect('/profile');
			}

			$user_country = $user_country->country;
			$country = DB::table("tbl_country")->get();

			$tbl_admin_category = new Event();
			$sports_category_list = $tbl_admin_category->getCategorySports();
			return view('organizer.create',compact('sports_category_list','user_country','result','event_id','country'));
	}

	public function test(){
		die('not found ddd');
		// return view('greeting', ['name' => $slug]);
	}

	public function testid($slug, $id){
		// return view('greeting', ['name' => $id]);
	}

	public function edit($id){
		//return view('organizer.create');
	}

	/**
	 *   Save Map Name Only for the update only
	 */
	public function saveMapOnly(Request $f){
		$user = Auth::user();

		DB::table('tbl_map')
					->where('id', $f->input('id'))
					->where('user_id', $user->id)
					->where('session_id', $f->input('session_id'))->update(
						[
							'map_name' => $f->input('map_name')	,
							'map_google_code' => $f->input('map_code')
						] );

		$all  = DB::table('tbl_map')
		->where('user_id', $user->id)
		->where('session_id',$f->input('session_id') )->get();

		$html = $this->populateEventMap($all);
		$msg  = array('html'=> $html['html'] , 'msg'=>'Save Map Code Sucessfully');
		return response()->json($msg);
	}

	/**
	 *  Inser Organizer Event initialy
	 */
	public function ajaxinitial(Request $request){


		$user = Auth::user();
		$id = 0 ;

		$found_error= '';

		$event_id = $request->input('event_id');

		if(empty($_POST['event_country'])){
			$found_error .= '<li>Country is required</li>';
		}

		if(empty($_POST['event_town'])){
			$found_error .= '<li>Town is required</li>';
		}


		if(empty($_POST['event_state'])){
			$found_error .= '<li>State is required</li>';
		}

		if(empty($_POST['event_zip'])){
			$found_error .= '<li>Zip is required</li>';
		}

		if(empty($_POST['event_name'])){
			$found_error .= '<li>Event Name is required</li>';
		}

		if(empty($_POST['daterace'])){
			$found_error .= '<li>Date Race is required</li>';
		}

		if( $_POST['reg_close_month'] ==''){
			$found_error .= '<li>Registration close Month is required</li>';
		}

		if( $_POST['reg_close_day'] ==''){
			$found_error .= '<li>Registration close Day is required</li>';
		}

		if( $_POST['event_description'] ==''){
			$found_error .= '<li>Event description is required</li>';
		}

		$array_output = $this->checkEventExist($request->input('session_id'));

		if($array_output['status'] == 1 || $found_error !=''){
			$event = array('msg'=>$found_error. $array_output['html'],'event_id'=>0,'status'=>0);
			return response()->json($event);
		}else{

			$CHECK_event = DB::table('tbl_organizer_event')
								->where('session_id' , $request->input('session_id'))
								->where('id',$request->input('event_id'))->get();

			if( $CHECK_event->isEmpty() )
			{
				DB::table('tbl_organizer_event')
					->insert(
							['user_id'  => $user->id,
							'session_id' => $request->input('session_id') ,
							'event_name' => $request->input('event_name_') ,
							'event_date_race' => $request->input('daterace'),
							'paymentdeadline' => $request->input('paymentdeadline'),
							'event_race_type' => $request->input('racetype'),
							'event_reg_close_month' => $request->input('reg_close_month'),
							'event_reg_close_day' => $request->input('reg_close_day'),
							'event_reg_close_time' => $request->input('reg_close_hour'),
							'event_registration_location' => $request->input('event_location'),
							'event_description' => $request->input('event_description'),
							'country' => $request->input('event_country'),
							'city_town' => $request->input('event_town'),
							'state' => $request->input('event_state'),
							'zip' => $request->input('event_zip'),
							'sports_type' => $request->input('sports_type'),
							'sports_type_other' => $request->input('sports_type_other'),
							'organizer_term_conditions'=>$request->input('organizer_term_condition')
							]);

				$id = DB::getPdo()->lastInsertId();

				$this->update_tables_with_events( array(
														'user_id' => $user->id,
														'session_id' => $request->input('session_id'),
														'event_id' => $id
													) ,
													array('tbl_category_events','tbl_map','tbl_awards')
												);

			} else {

				DB::table('tbl_organizer_event')
					->where('id', $request->input('event_id'))
					->where('user_id', $user->id)
					->where('session_id', $request->input('session_id'))->update(
						['event_name' => $request->input('event_name') ,
						'event_date_race' => $request->input('daterace'),
						'paymentdeadline' => $request->input('paymentdeadline'),
						'event_race_type' => $request->input('racetype'),
						'event_reg_close_month' => $request->input('reg_close_month'),
						'event_reg_close_day' => $request->input('reg_close_day'),
						'event_reg_close_time' => $request->input('reg_close_hour'),
						'event_registration_location' => $request->input('event_location'),
						'event_description' => $request->input('event_description')	,
						'country' => $request->input('event_country'),
						'city_town' => $request->input('event_town'),
						'state' => $request->input('event_state'),
						'zip' => $request->input('event_zip'),
						'sports_type' => $request->input('sports_type'),
						'sports_type_other' => $request->input('sports_type_other')
						]);

				$id = $request->input('event_id');

				$this->update_tables_with_events( array(
							'user_id' => $user->id,
							'session_id' => $request->input('session_id'),
							'event_id' => $id
						) ,
						array('tbl_category_events','tbl_map','tbl_awards')
					);
			}

			$event = array('msg'=>'Event Saved','event_id'=>$id,'status'=>1);
			return response()->json($event);
		}
	}

	 /**
	  *  Call this when Saving event PHOTO
	  */
	public function initentry(Request $request)
	{
			$uploads_dir = 'uploads';
			$user = Auth::user();


			foreach ($_FILES["userfile"]["error"] as $key => $error)
			{

			    if($error == UPLOAD_ERR_OK) {
					$tmp_name = $_FILES["userfile"]["tmp_name"][$key];

					 $ext = pathinfo(basename($_FILES["userfile"]["name"][$key], PATHINFO_EXTENSION));
					 $extention = $ext['extension'];

					//echo basename($_FILES["userfile"]["name"][$key]);

			        // basename() may prevent filesystem traversal attacks;
			        // further validation/sanitation of the filename may be appropriate
					//$name = $user->id.'_'.date('dmyhs').'_'.basename($_FILES["userfile"]["name"][$key]);
					$name = $user->id.'_'.date('dmyhs').'_'.date('dmyhs').'.'.$extention;
			        move_uploaded_file($tmp_name, "$uploads_dir/$name");
			    }
			}

			$media = $uploads_dir.'/'.$name;
			$tasks = array('POST_ID'=>12,'MEDIA'=>$media);

			$checkifExist = DB::table('tbl_organizer_event')
				 ->where('session_id', $request->input('session_id'))
				 ->where('user_id', $user->id)
				 ->where('id',$request->input('event_id'))
				 ->get();

			if(!$checkifExist->isEmpty()){
				DB::table('tbl_organizer_event')
				->where("user_id", $user->id )
				->where("id", $request->input('event_id'))
				->update( ['event_image_name' => $name] );

				$organizer2 = DB::table('tbl_organizer_event')
                ->where('session_id', $request->input('session_id'))
				 ->where('user_id', $user->id)
				 ->where("id", $request->input('event_id'))
				->get();

			}else{
				DB::table('tbl_organizer_event')->insert( ['event_image_name' => $name, 'user_id' => $user->id, 'session_id' => $request->input('session_id')] );
				$organizer2 = DB::table('tbl_organizer_event')
                ->where('session_id', $request->input('session_id'))
                 ->where('user_id', $user->id)
                ->get();
			}


            $id = '';

            foreach ($organizer2 as $key => $value)
            {
                $id = $value->id;
            }

            $tasks = array('event_id'=>$id,'MEDIA'=>$media);
			return response()->json($tasks);
	}

	/**
	 *  Delete category by ID
	 */
	public function deleteCategory(Request $request)
	{
		$user = Auth::user();
		$user_id = $user->id;
		$catid = $request->input('cat_id');
		DB::table('tbl_category_events')->where('id', $catid)->delete();
	}

	/**
	 *  Event edit function here
	 *
	 *
	 * ***/
	public function populate_eventCategory_list( Request $request ){
		$user = Auth::user();
		$user_id = $user->id;

		$this->current_cat_id = $request->input('event_id');

		$category = DB::table('tbl_category_events')
				->where('event_id',$request->input('event_id'))
				->where('user_id', $user_id)
                ->get();

		$html =  $this->populateCats($category);

		$addCategory  = array("html"=>$html,"event_id"=>$request->input('event_id'),'message'=>'success');
		return response()->json($addCategory);
	}



	/**
	 *  Creating Event Category
	 */

	public function addCategory(Request $request)
	{
		$user = Auth::user();
		$session_id = $request->input('session_id');
		$event_id = '';

		// check if theirs is organizer event
		$organizer = DB::table('tbl_organizer_event')->where('session_id',$session_id)->get();

		if ($organizer->isEmpty())
		{
			 DB::table('tbl_organizer_event')->insert( ['user_id' => $user->id,  'session_id' => $request->input('session_id')] );
		}

		$organizer2 = DB::table('tbl_organizer_event')
                ->where('session_id', $session_id)
                ->get();

		if (!$organizer2->isEmpty()) {
			$event_id = $organizer2[0]->id;
		}

		// BEFORE E INSERT CHECK IF NAABAY EXISTING DOLLAR SIGNS
		//$tbl_category_events = $this->set_shop_symbol( $request->input('session_id'));
		$session_country_name = $this->getCategoryCurrencyName($request->input('session_id'));
		$is_not_thesame_currency = 0;

		if( $session_country_name == ''){
		}else{
			if( $request->input('currency') == $session_country_name ){
			}else{
				$is_not_thesame_currency = 1;
			}
		}

		if($is_not_thesame_currency==1)
		{
			DB::table('tbl_category_events')
					->where('id', $request->input('event_id'))
					->where('user_id', $user->id)
					->where('session_id', $request->input('session_id'))
					->update([
						'currency' => $request->input('currency')
					]);
		}

		// Edit if e click ang category edit
		if( $request->input('mode') == 'edit')
		{
			$id = $request->input('cat_id');

			// update the country for the currency
			$this->current_cat_id = $id	;

			DB::table('tbl_category_events')
			    ->where('id', $id)->update(
				['user_id'  => $user->id,
				 'event_id' => $event_id,
				 'category_name' => $request->input('category_name') ,
				 'currency' => $request->input('currency') ,
				 'session_id' => $request->input('session_id') ,
				 'race_limit' => $request->input('race_limit'),
				 'cat_5k_setup' => $request->input('five_k_setup') ,
				 'cat_5k_registration_type' => $request->input('cat_registration_type'),
				 'cat_local_early_bird_rate' => $request->input('local_early_bird_rate_amount'),
				 'cat_local_early_bird_end_date' => $request->input('local_early_bird_rate_end_date'),
				 'cat_local_reg_rate' => $request->input('local_regular_rate_amount'),
				 'cat_local_reg_end_date' => $request->input('local_regular_rate_end_date'),
				 'cat_local_late_reg_rate' => $request->input('local_late_reg_rate_amount'),
				 'int_early_bird_rate_amount' => $request->input('int_early_bird_rate_amount'),
				 'int_early_bird_rate_end_date' => $request->input('int_early_bird_rate_end_date'),
				 'int_regular_rate_amount' => $request->input('int_regular_rate_amount'),
				 'int_regular_rate_end_date' => $request->input('int_regular_rate_end_date'),
				 'int_late_reg_rate_amount' => $request->input('int_late_reg_rate_amount'),
				 'max_participants' => $request->input('max_participants'),
				// 'currency' => $request->input('currency') ,
				] );
		}else{
		// if dili mode edit then create
		$insert_cat = DB::table('tbl_category_events')->insertGetId(
				['user_id'  => $user->id,
				 'event_id' => $event_id, /** if no event can be inserted but update if click button */
				 'session_id' => $request->input('session_id') ,
				 'race_limit' => $request->input('race_limit'),
				 'category_name' => $request->input('category_name') ,
				 'currency' => $request->input('currency') ,
				 'cat_5k_setup' => $request->input('five_k_setup') ,
				 'cat_5k_registration_type' => $request->input('cat_registration_type'),
				 'cat_local_early_bird_rate' => $request->input('local_early_bird_rate_amount'),
				 'cat_local_early_bird_end_date' => $request->input('local_early_bird_rate_end_date'),
				 'cat_local_reg_rate' => $request->input('local_regular_rate_amount'),
				 'cat_local_reg_end_date' => $request->input('local_regular_rate_end_date'),
				 'cat_local_late_reg_rate' => $request->input('local_late_reg_rate_amount'),
				 'int_early_bird_rate_amount' => $request->input('int_early_bird_rate_amount'),
				 'int_early_bird_rate_end_date' => $request->input('int_early_bird_rate_end_date'),
				 'int_regular_rate_amount' => $request->input('int_regular_rate_amount'),
				 'int_regular_rate_end_date' => $request->input('int_regular_rate_end_date'),
				 'int_late_reg_rate_amount' => $request->input('int_late_reg_rate_amount'),
				 'max_participants' => $request->input('max_participants')
				] );


			$this->current_cat_id = $insert_cat	;
		}

		// update all cats to the new currency
		// e update ang mga category to one currency dili pwedi ug lahi2x
		DB::table('tbl_category_events')
					->where('user_id', $user->id)
					->where('session_id', $request->input('session_id'))->update([
						'currency' => $request->input('currency')
						]);

		$this->getCurrencyByCats();

		// Query it by session
		$category = DB::table('tbl_category_events')
                ->where('session_id', $session_id)
                ->get();


		$html =  $this->populateCats($category);


		$addCategory  = array("html"=>$html,"event_id"=>$event_id,'message'=>'success','what_country'=>$session_country_name ,'not'=>$is_not_thesame_currency);
		return response()->json($addCategory);
	}


	/**
	 *  GET ALL CATEGORY PUT TO DROPDOWN
	 */
	PUBLIC function getCategoryDropdown(Request $f)
	{
		$user = Auth::user();
		$category = DB::table('tbl_category_events')
					->where('session_id', $f->input("session_id"))
					->where('user_id', $user->id)
					->where('event_id', $f->input("event_id"))
					->get();

		$html = array();
		$dropdownselect ='';

		if(!$category->isEmpty() )
		{
			$dropdownselect .= '<select style="height:33px;font-size:12px;" class="dropdown_coupon custom-select dselect d-block w-100">';
			foreach($category as $v)
			{
				$dropdownselect .= '<option value="'.$v->id.'">'.$v->category_name.'</option>';
			}
			$dropdownselect .= '</select>';
		}
		return response()->json( array('html'=>$dropdownselect) );
	}


	// GET EVENT CATEGORY
	public function getCategoryByID(Request $f)
	{

		$user = Auth::user();
		$category = DB::table('tbl_category_events')
					->where('session_id', $f->input("session_id"))
					->where('user_id', $user->id)
					->where('id', $f->input("id"))
					->get();

		$html = array();

		if(!$category->isEmpty() )
		{
			foreach($category as $v)
			{
				$html = $v;
			}
		}

		$addCategory  = $html;
		return response()->json($addCategory);
	}

	/** Event Map image  */
	public function uploadMapImage(Request $request)
	{

			$uploads_dir = 'uploads';
			$user = Auth::user();
			foreach ($_FILES["userfile"]["error"] as $key => $error)
			{
			    if($error == UPLOAD_ERR_OK) {
			        $tmp_name = $_FILES["userfile"]["tmp_name"][$key];
			        // basename() may prevent filesystem traversal attacks;
			        // further validation/sanitation of the filename may be appropriate
			        $name = $user->id.'_map_image_'.date('dmyhs').'_'.basename($_FILES["userfile"]["name"][$key]);
			        move_uploaded_file($tmp_name, "$uploads_dir/$name");
			    }
			}

			$media = $uploads_dir.'/'.$name;

			$organizer = DB::table('tbl_organizer_event')->where('session_id', $request->input('session_id') )->get();

			if ($organizer->isEmpty())
			{
				DB::table('tbl_organizer_event')->insert( ['user_id' => $user->id,  'session_id' => $request->input('session_id')] );
			}

			if( $request->input('mode') =='edit' )
			{
				DB::table('tbl_map')
				->where("user_id", $user->id )
				->where("id", $request->input('id'))
				->where("session_id", $request->input('session_id'))
				->update( ['session_id' => $request->input('session_id'),
							'map_name'   => $request->input('map_name'),
							'map_google_code' => '',
							'map_image'  => $media] );

				$all  = DB::table('tbl_map')
							->where('user_id', $user->id)
							->where('session_id',$request->input('session_id') )->get();
			} else
			{
				DB::table('tbl_map')->insert([
												'session_id' => $request->input('session_id'),
												'map_name'   => $request->input('map_name'),
												'map_image'  => $media,
												'event_id'   => $request->input('event_id'),
												'map_google_code' => '',
												'user_id'    => $user->id
											]);

				$all  = DB::table('tbl_map')
						->where('user_id', $user->id)
						->where('session_id',$request->input('session_id') )->get();
			}

			$html = $this->populateEventMap($all);
			$msg  = array('html'=> $html['html'] , 'msg'=>'Save Map Code Sucessfully');
			return response()->json($msg);
	}

	/**
	 *  Populates Cats
	 */
	function populateCats($category)
	{
		$html = '';

		if (!$category->isEmpty())
		{
			foreach($category as $values)
			{
				$v = $values->cat_5k_registration_type;

				$cats_symbol = $this->getCurrentrequestCat($values->id); // category id

				$ht = '';

				if($v!=='Individual')
				{
					$ht = '<div class="col-md-6 mb-4">
								<label for="racetype">'.$v.' Limit</label>
								<input disabled class="form-control" type="text" value="'.$values->race_limit.'" />
						</div>';
				}

				$eary_bird_rate 	= ( $values->cat_local_early_bird_rate == '') ? '' : $cats_symbol . $values->cat_local_early_bird_rate;
				$cat_local_reg_rate = ( $values->cat_local_reg_rate == '') ? '' : $cats_symbol . $values->cat_local_reg_rate;
				$cat_local_late_reg_rate = ( $values->cat_local_late_reg_rate == '') ? '' : $cats_symbol . $values->cat_local_late_reg_rate;

				$int_early_bird_rate_amount = ( $values->int_early_bird_rate_amount == '') ? '' : "$" . $values->int_early_bird_rate_amount;
				$int_regular_rate_amount    = ( $values->int_regular_rate_amount    == '') ? '' : '$' . $values->int_regular_rate_amount;
				$int_late_reg_rate_amount   = ( $values->int_late_reg_rate_amount   == '') ? '' : '$' . $values->int_late_reg_rate_amount;

				$h ='<select name="category_registration_type" class="custom-select d-block w-100 category_registration_type" id="country" required="">
						<option '.(($v == 'Individual') ? "selected='selected'" :"").' value="Individual">Individual</option>
						<option '.(($v == 'Team') ? "selected='selected'" :"").' value="Team">Team</option>
						<option '.(($v == 'Relay') ? "selected='selected'":"").' value="Relay">Relay</option>
					</select>

					<div style="display:none; margin-top:20px;" class="inputteamp_relay">
						<label for="limit" class="limit_name">Limit</label><span class="required">*</span>
						<input class="form-control limit_input_race" type="text" name="limit" x-limit-type="" value="">
					</div>';

				$html .='<div id="race_category_wrapper_id_'.$values->id.'" class="race_category" style="/*! display:none; */position: relative;"><span xid-race-category="'.$values->id.'" class="close_button_race_category button_close" style="">x</span>

							<div class="row mb-4">
								<div class="col-md-12">
									<label for="racetype">Category Name</label>
									<input disabled value="'.$values->category_name.'" name="category_name" type="text" class="form-control category_name" placeholder="">
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 mb-4" style="display:none">
									<label for="racetype">Set Up</label>
									<input value="'.$values->cat_5k_setup.'" name="5k_open_set_up" type="text" id="5k_open_set_up" class="form-control 5k_open_set_up five_k_setup" placeholder="Set up">
								</div>
								<div class="col-md-6 mb-4">
									<label for="racetype">Ragistration Type</label>
									<input disabled class="form-control" type="text" value="'.$v.'" />
								</div>
								<div class="col-md-2 mb-2">
									<label for="racetype">Max Participants</label>
									<input disabled class="form-control" type="text" value="'.$values->max_participants.'" />
								</div>
								'.$ht.'
							</div>

							<div><h6><strong>Local Rate</strong></h6></div>

							<div class="row">
								<div class="col-md-6 mb-4">
									<label for="racetype">Early Bird Rate</label>
									<input disabled value="'. $eary_bird_rate .'" type="text" id="local_early_bird_rate_amount" name="local_early_bird_rate_amount" class="form-control local_early_bird_rate_amount" placeholder="">
								</div>
								<div class="col-md-6 mb-4">
									<label for="racetype">End Date</label>
									<input disabled value="'.$values->cat_local_early_bird_end_date .'" type="text" id="local_early_bird_rate_end_date" name="local_early_bird_rate_end_date" class="form-control local_early_bird_rate_end_date" placeholder="">
								</div>
							</div>

							<div class="row">
								<div class="col-md-6 mb-4">
									<label for="racetype">Regular Rate</label>
									<input disabled value="'.$cat_local_reg_rate .'" type="text" id="local_regular_rate_amount" name="local_regular_rate_amount" class="form-control local_regular_rate_amount" placeholder="">
								</div>
								<div class="col-md-6 mb-4">
									<label for="racetype">End Date</label>
									<input disabled value="'.$values->cat_local_reg_end_date .'" type="text" id="local_regular_rate_end_date" name="local_regular_rate_end_date" class="form-control local_regular_rate_end_date" placeholder="">
								</div>
							</div>

							<div class="row">
								<div class="col-md-6 mb-4">
									<label for="racetype">Late Reg Rate</label>
									<input disabled value="'.$cat_local_late_reg_rate .'" type="text" id="local_late_reg_rate_amount" name="local_late_reg_rate_amount" class="form-control local_late_reg_rate_amount" placeholder="">
								</div>
							</div>

							<div><h6><strong>International Rate</strong></h6></div>

							<div class="row">
								<div class="col-md-6 mb-4">
									<label for="racetype">Early Bird Rate</label>
									<input disabled value="'.$int_early_bird_rate_amount .'"  type="text" id="international_early_bird_rate_amount" name="international_early_bird_rate_amount" class="form-control international_early_bird_rate_amount" placeholder="">
								</div>
								<div class="col-md-6 mb-4">
									<label for="racetype">End Date</label>
									<input disabled value="'.$values->int_early_bird_rate_end_date .'" type="text" id="international_early_bird_rate_end_date" class="form-control international_early_bird_rate_end_date" name="international_early_bird_rate_end_date" placeholder="">
								</div>
							</div>

							<div class="row">
								<div class="col-md-6 mb-4">
									<label for="racetype">Regular Rate</label>
									<input disabled type="text" value="'.$int_regular_rate_amount .'" id="international_regular_rate_amount" name="international_regular_rate_amount" class="form-control international_regular_rate_amount" placeholder="">
								</div>
								<div class="col-md-6 mb-4">
									<label for="racetype">End Date</label>
									<input disabled type="text"  value="'.$values->int_regular_rate_end_date .'" id="international_regular_rate_end_date" name="international_regular_rate_end_date" class="form-control international_regular_rate_end_date" placeholder="">
								</div>
							</div>

							<div class="row">
								<div class="col-md-6 mb-4">
									<label for="racetype">Late Reg Rate</label>
									<input disabled value="'.$int_late_reg_rate_amount .'" type="text" id="late_reg_rate_amount" name="late_reg_rate_amount" class="form-control international_late_reg_rate_amount" placeholder="">
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-2 mb-4">
									<button xid-race-category="'.$values->id.'" class="btn btn-primary btn-lg btn-block btn-edit-race-cat" type="button">Edit Info</button>
									<span class="info_id_'.$values->id.'"></span>
								</div>
							</div>
						</div>';
			}
		}
		return $html;
	}

	/*
	 * Upload Awards
	 */
	public function uploadAwards()
	{
			$uploads_dir = 'uploads';
			$user = Auth::user();

			foreach ($_FILES["userfile"]["error"] as $key => $error)
			{
				if($error == UPLOAD_ERR_OK)
				{
			        $tmp_name = $_FILES["userfile"]["tmp_name"][$key];
			        $name = $user->id.'_awards_'.date('dmyhs').'_'.basename($_FILES["userfile"]["name"][$key]);
			        move_uploaded_file($tmp_name, "$uploads_dir/$name");
			    }
			}

			$media = $uploads_dir.'/'.$name;
			$tasks = array('POST_ID'=>12,'MEDIA'=>$media);
			$serialize = base64_encode(serialize($_POST['list_item_']));

			if( $_POST['mode_type'] == 'edit' )
			{
				if( $_POST['xid'] > 0  )
				{
					 if(empty( $_POST['event_id'])){
						$event_id = 0;
					 }else{
						$event_id = $_POST['event_id'];
					 }

					DB::table('tbl_awards')->where('user_id',$user->id)
					->where('event_id',$event_id)
					->where('id', $_POST['xid'])
					->update( ['event_id'=> $event_id , 'list_items' => $serialize, 'awards_image' => $name, 'awards_name' => $_POST['awards_name']] );
				}
			}else{
				$event_id = ( $_POST['event_id'] == '') ? 0 : $_POST['event_id'];
				DB::table('tbl_awards')->insert( ['event_id'=> $event_id  , 'session_id' => $_POST['session_id'],'list_items' => $serialize, 'awards_image' => $name, 'awards_name' => $_POST['awards_name'],'user_id' => $user->id] );
			}
			return response()->json($tasks);
	}

	/**
	 *  Save Awards Only
	 */
	public function save_awards_only(Request $s){
		$user = Auth::user();

		$serialize = base64_encode(serialize($_POST['list_item_']));
		DB::table('tbl_awards')->where('user_id',$user->id)
		->where('event_id',$_POST['event_id'])
		->where('id', $_POST['id'])
		->update( ['list_items' => $serialize, 'awards_name' => $_POST['award_name']] );

		$html = $this->getAllAwards($s , $type = 'html');
		return response()->json($html);
	}

	/**
	 *  Get Question By Session
	 */
	public function getQuestionBySession(Request $request){
		//$all = DB::table('tbl_additional_question')->where('session_id', $request->input('session_id'))->get();
		//if(!$all->isEmpty()){
		//}

		$user = Auth::user();
		$all  = DB::table('tbl_additional_question')
				 ->where('user_id', $user->id)
				 ->where('session_id',$request->input('session_id') )->get();

		 // $html = $this->populateEventMap($all);

		 $html = $this->populate_question_html($all);
		 $msg  = array('html'=> $html , 'msg'=>'Retrieved question successfully');
		 return response()->json($msg);
	}

	/**
	 *  Clone awards
	 */
	public function clone_award(Request $f){
		$user = Auth::user();
		$getawards = DB::table('tbl_awards')
					->where('id', $f->input('ID'))
					->where('user_id',$user->id)->get();

		if(count($getawards)>0)
		{
			foreach ($getawards as $key => $value)
			{
				DB::table('tbl_awards')->insert([
					'awards_name'  => "Copy_".$value->awards_name,
					'list_items'   => $value->list_items,
					'list_title'   => $value->list_title,
					'awards_image' => $value->awards_image,
					'event_id'     => $value->event_id,
					'session_id'   => $value->session_id,
					'user_id'      => $value->user_id
				]);
			}

			$html = $this->getAllAwards($f , $type = 'html');
			return response()->json($html);
		}
	}

	/**
	 *  Get All Awards
	 */
	public function getAllAwards(Request $request , $type= null){
		 $all = DB::table('tbl_awards')
			 ->where('user_id', Auth::user()->id)
			 ->where('event_id', $request->input('event_id'))
			 ->where('session_id', $request->input('session_id'))->get();

		 $html = '';

		 $ul_list_holder  ='';
		 foreach($all as $values)
		 {
			$unser = base64_decode($values->list_items);

			$unseree = unserialize($unser);

			$ul_list 	 ='';
			$list 	     = '';
			$LIST_HOLDER = '';

			foreach($unseree as $v)
			{
				$ul_list ='<label for="racetype">'.$v['title'].'</label>';
				$list = '';
				$explode = explode(',', $v['name']);

				if( sizeof($explode) == 0 )
				{
					$list = $explode[0];
				}else{
					foreach ($explode as $key => $value) {
						$list .='<li>'.$value.'</li>';
					}
				}

				$LIST_HOLDER .= $ul_list . '<ul>'.$list.'</ul>';

			}

			$ul_list_holder =  $LIST_HOLDER;

		 	$html .= '<div class="col-md-3 mb-4 block_box_award">
				    	<span x-id="'.$values->id.'" class="close_button_awards button_close" style="">x</span>
	         			<div><h6><strong>'.$values->awards_name.'</strong></h6></div>
				        '.$ul_list_holder.'
						 <button x-award-id="'.$values->id.'" class="btn btn-primary btn-lg btn-block btn-award-box btn-award-box-edit" type="button">Edit Award</button>
						 <button style="background: #DDDDDD !important; border-radius: 0px !important;border: 0px !important;font-size: 12px !important;color: #595858 !important" x-award-id="'.$values->id.'" class="btn btn-primary btn-lg btn-block btn-award-box-clone btn-award-box-clone" type="button">Clone Award</button>
					</div>';

		 }
		 if($type == 'html'){
			return  array('block' => $html);
		 }else{
			return response()->json(array('block' => $html));
		 }


	}

	/*
	 * Awards image upload
	 */
	public function uploadMap(){
		$uploads_dir = 'uploads';
			$user = Auth::user();
			foreach ($_FILES["userfile"]["error"] as $key => $error)
			{
			    if($error == UPLOAD_ERR_OK) {
			        $tmp_name = $_FILES["userfile"]["tmp_name"][$key];
			        // basename() may prevent filesystem traversal attacks;
			        // further validation/sanitation of the filename may be appropriate
			        $name = $user->id.'_awards_'.date('dmyhs').'_'.basename($_FILES["userfile"]["name"][$key]);
			        move_uploaded_file($tmp_name, "$uploads_dir/$name");
			    }
			}

			$media = $uploads_dir.'/'.$name;
			$tasks = array('POST_ID'=>12,'MEDIA'=>$media);
			$serialize = base64_encode(serialize($_POST['list_item_']));

			DB::table('tbl_awards')->insert( ['session_id' => $_POST['session_token'],'list_items' => $serialize, 'awards_image' => $name, 'awards_name' => $_POST['awards_name'],'user_id' => $user->id] );
			return response()->json($tasks);
	}

	/**
	 *  Save Google Code Map
	 */
	public function saveMapgoogleCode(Request $request){
		$user = Auth::user();
		$maptype = $request->input('map_type');
		if($request->input('mode') =='edit' ){

			$event_id = ( $request->input('event_id') == 0 ) ? 0 : $request->input('event_id');
			//echo   $request->input('google_map');

			DB::table('tbl_map')
				->where('user_id',$user->id)
				->where('event_id',$event_id)
				->where('id', $request->input('id'))->update([ 'type_map'=>$maptype,'map_name' => $request->input('map_name'), 'map_image'=> '' ,'map_google_code' => $request->input('google_map')] );
		}else{
			$event_id = ( $request->input('event_id') == 0 ) ? 0 : $request->input('event_id');
			DB::table('tbl_map')->insert( ['type_map'=>$maptype,'event_id'=> $event_id, 'session_id' => $request->input('session_id'), 'map_name' => $request->input('map_name'), 'map_google_code' => $request->input('google_map'),'user_id' => $user->id] );
		}

		$all = DB::table('tbl_map') ->where('user_id', $user->id)->where('session_id', $request->input('session_id'))->get();

		$html = $this->populateEventMap($all);
		$msg = array('html'=> $html['html'] , 'msg'=>'Save Map Code Sucessfully');
		return response()->json($msg);
	}

	/**
	 *  Populate Event Map
	 */
	public function populateEventMap($all){

		$count = 1 ;
		$html = '';

		foreach ($all as $key => $value)
		{
			if($count == 1)
			{
			   $html .= '<div id="map_row_id_'.$value->id.'" class="row">
			         	    <div class="col-md-10 mb-4" style="display:block;margin-left:-15px;padding-right: 0px;">
						    	<input value="1. '.$value->map_name.'" type="text" name="race_map" class="form-control input-grey">
						    </div>
						     <div style="height: 56px;margin-right:2px;" class="col-md-1 mb-4 addbox_map">
						    	<div x-map-id="'.$value->id.'" class="boxaddmapedit" style="line-height: 56px;font-size: 12px;">
						    		+ Edit
						    	</div>
						    </div>
						    <div style="height: 56px" class="col-md-1 mb-4 addbox_map">
						    	<div x-map-id="'.$value->id.'" class="boxaddmap_delete" style="line-height: 56px;font-size: 12px;">
						    		Delete
						    	</div>
						    </div>
					 	 </div>	 ';
			}else{
				 $count_ = $count;
				 $html .= '<div id="map_row_id_'.$value->id.'" class="row">
			         	    <div class="col-md-10 mb-4" style="display:block;margin-left:-15px;padding-right: 0px;">
						    	<input type="text" value="'.$count_ . '. '.$value->map_name.'" name="race_map" class="form-control input-grey">
						    </div>
						     <div style="height: 56px;margin-right:2px;" class="col-md-1 mb-4 addbox_map">
						    	<div x-map-id="'.$value->id.'" class="boxaddmapedit" style="line-height: 56px;font-size: 12px;">
						    		+ Edit
						    	</div>
						    </div>
						    <div style="height: 56px" class="col-md-1 mb-4 addbox_map">
						    	<div x-map-id="'.$value->id.'" class="boxaddmap_delete" style="line-height: 56px;font-size: 12px;">
						    		Delete
						    	</div>
						    </div>
					 	 </div>	 ';
			}
			$count++;
		}

		if($html !=''){
			$html .= '<div class="row"><div style="height: 56px" class="col-md-1 mb-4 addbox_map">
									<div class="boxaddmap" style="height: 55px;line-height: 30px;">
										+ Add
									</div>
					</div></div>';
		}

		return $msg = array('html'=> $html , 'msg'=>'Save Map Code Sucessfully');

	}

	/**
	 *  Delete Map
	 */
	public function delete_map(Request $request){
		$user = Auth::user();

		DB::table('tbl_map')
			->where('user_id', $user->id)
			->where('id',  $_GET['id'])
		    ->where('session_id', $_GET['session_id'])->delete();
		    $msg = array('msg'=>'Map Deleted Sucessfully');
			return response()->json($msg);
	}

	 /*
	  *  Get the Map when clicking EDIT button beside delete
	  */
	public function get_map_by_id($session_id, $id)
	{
		$user = Auth::user();

		$result = DB::table('tbl_map')
		    ->where('user_id', $user->id)
		    ->where('id', $id)
		    ->where('session_id', $session_id)->get();

		foreach($result as $values)
		{
			$map_name = $values->map_name;
			$map_google_code = $values->map_google_code;
			$map_image = $values->map_image;
		}

		$msg = array('map_name'=>$map_name,'map_image'=>$map_image,'map_google_code'=>$map_google_code);
		return response()->json($msg);
	}

	public function save_question(Request $request){
		$user = Auth::user();
		DB::table('tbl_additional_question')->insert(
				['user_id'  => $user->id,
				 'event_id' => $request->input('event_id'),
				 'session_id' => $request->input('session_id') ,
				 'question' => $request->input('question_name') ,
				 'upload_image' => $request->input('cat_registration_type'),
				] );


		$result = DB::table('tbl_additional_question')
		    ->where('user_id', $user->id)
		    ->where('event_id', $request->input('event_id'))
		    ->where('session_id', $request->input('session_id') )->get();

		$html = '';
		$title = '';

		$html = $this->populate_question_html($result);

		$msg = array('html'=>$html);
		return response()->json($msg);
	}

	/**
	 * Sort question
	 */
	public function sortquestion(){
		$id  = $_POST['id'];
		$key = $_POST['sort_index'];

		DB::table('tbl_additional_question')
			->where('user_id', Auth::user()->id)
			->where('id',$id)->update([
				'sort' => $key
			]);
	}

	/**
	 *  Population of question for event backend organizer
	 */
	public function populate_question_html($result){
		$html = '';

		foreach($result as $values)
		{
			$title = ( $values->upload_image =='' ) ?  $values->question  : $values->upload_image ;
			$html .= '<div id="additional_row_'.$values->id.'" class="row additional_row_'.$values->id.'" x-parent="'.$values->id.'" style="margin-top:4px;">
						<div class="col-md-6" style="padding-right: 0px;">
							<input class="form-control input-grey input_medical_upload" type="text" value="'.$title.'" name="upload_medical_cert">
						</div>
						<div x-question-type="'.$values->question_type.'"  x-question-id="'.$values->id.'" class="col-md-1 col-sm-2 col-xm-2 additional_info_edit" style="">
						Edit
						</div>
						<div x-question-id="'.$values->id.'" class="col-md-1 col-sm-2 col-xm-2 additional_info_delete" style="">
						Delete
						</div>
						<div x-move-id="'.$values->id.'" class="col-md-1 col-sm-2 col-xm-2 additional_info_up" style="background: #f2f2f2;padding-top: 14px;text-align: center;">
						<i class="fa fa-angle-up" aria-hidden="true"></i>
						</div>
						<div x-move-id="'.$values->id.'" class="col-md-1 col-sm-2 col-xm-2 additional_info_down" style="background: #f2f2f2;padding-top: 14px;text-align: center;">
						<i class="fa fa-angle-down" aria-hidden="true"></i>
						</div>
					  </div>';
		}

		return $html;
	}

	/**
	 *  De el question es meio rata el santo nanio
	 */
	public function deleteQuestion(Request $request)
	{
		$user = Auth::user();
		DB::table('tbl_additional_question')
			->where('user_id',$user->id)
			->where('event_id',$request->input('event_id'))
			->where('id',$request->input('id'))
			->where('session_id',$request->input('session_id'))->delete();

		$msg = array('html'=>'Deleted Question');

		return response()->json($msg);
	}

	public function getQuestion(Request $f){
		$get = DB::table('tbl_additional_question')
		->where('user_id', Auth::user()->id)
		->where('event_id',$f->input('event_id'))
		->where('id',$f->input('id'))
		->where('session_id',$f->input('session_id'))->get();


		$image = '';
		$question = '';


		foreach($get as $val ){
			$image = '<img src="'.url('/').'/'.$val->upload_image .' " width="20%">';
			$question = $val->question;
		}

		$msg = array('image'=>$image,'question'=>$question,'html'=>'Retrieved Question');
		return response()->json($msg);
	}

	// SAVE QUESTION HERE
	public function addQuestionOnly(Request $request){
		$user = Auth::user();
		if( $request->input('mode') =='edit')
			{
				// remove image here in public upload
				// Edit here
				DB::table('tbl_additional_question')
					->where('user_id',$user->id)
					->where('event_id',$request->input('event_id'))
					->where('id',$request->input('id'))
					->where('session_id',$request->input('session_id'))->update(
						[
						'event_id'     => $request->input('event_id'),
						'session_id'   => $request->input('session_id') ,
						'question'     => $request->input('question'),
						'question_type' => $request->input('type')
						]);
			}else{
				DB::table('tbl_additional_question')->insert(
					['user_id'     => $user->id,
					'event_id'     => $request->input('event_id'),
					'session_id'   => $request->input('session_id') ,
					'question'     => $request->input('question'),
					'question_type' => $request->input('type')
					]);
			}

			return $msg = ($this->getQuestionBySession($request));


	}

	public function ajax_upload_question(Request $request){
			$user = Auth::user();
			$uploads_dir = 'uploads';

			foreach ($_FILES["userfile"]["error"] as $key => $error)
			{
			    if($error == UPLOAD_ERR_OK) {
			        $tmp_name = $_FILES["userfile"]["tmp_name"][$key];
			        $name = $user->id.'_question_'.date('dmyhs').'_'.basename($_FILES["userfile"]["name"][$key]);
			        move_uploaded_file($tmp_name, "$uploads_dir/$name");
			    }
			}

			if( $request->input('mode') =='edit')
			{
				// remove image here in public upload
				// Edit here
				DB::table('tbl_additional_question')
					->where('user_id',$user->id)
					->where('event_id',$request->input('event_id'))
					->where('id',$request->input('id'))
					->where('session_id',$request->input('session_id'))->update(
						['upload_image' => $uploads_dir.'/'.$name ,
						'question'     => $request->input('question_name')
						]);
			}else{
				DB::table('tbl_additional_question')->insert(
					['user_id'     => $user->id,
					'event_id'     => $request->input('event_id'),
					'session_id'   => $request->input('session_id') ,
					'upload_image' => $uploads_dir.'/'.$name ,
					'question'     => $request->input('question_name')
					]);
			}

		die();
	}

	/**
	 *  Shop , callig function is from drop.js
	 */
	public function save_shop_product(Request $request){
			$user = Auth::user();
			$uploads_dir = 'uploads';
			$user = Auth::user();
			foreach ($_FILES["userfile"]["error"] as $key => $error)
			{
			    if($error == UPLOAD_ERR_OK) {
			        $tmp_name = $_FILES["userfile"]["tmp_name"][$key];
			        // basename() may prevent filesystem traversal attacks;
			        // further validation/sanitation of the filename may be appropriate
			        $name = $user->id.'_product_'.date('dmyhs').'_'.basename($_FILES["userfile"]["name"][$key]);
			        move_uploaded_file($tmp_name, "$uploads_dir/$name");
			    }
			}

			$media = $uploads_dir.'/'.$name;

			$product_sizes = base64_encode(serialize($_POST['size']));


			if($request->input('is_has_variant') =='true'){
				$variant = 1;
			}else{
				$variant = 0;
			}


			if($request->input('mode')=='edit'){
				DB::table('tbl_products')->where('id',$request->input('xid'))->update(
					['user_id'  => $user->id,
					'event_id' => $request->input('event_id'),
					'session_id' => $request->input('session_id') ,
					'product_name' => $request->input('shop_product_name') ,
					//'product_stock' => $request->input('shop_product_stock'),
					'product_max_qty' => $request->input('product_max_qty'),
					'product_price'   => $request->input('shop_product_price'),
					'description' => $request->input('description'),
					//'product_sizes' => $product_sizes,
					'product_image' => $name,
					//'color' => $request->input('color_name_shop')
					'is_product_has_variant' => $variant,
					'is_mandatory' => $request->input('is_mandatory')
					]);
					$last_id = $request->input('xid');
			}else{

				if($_POST['is_mandatory']==0){
					$manda = 0;
				}else{
					$manda = 1;
				}

				DB::table('tbl_products')->insert(
												['user_id'  => $user->id,
												'event_id' => $request->input('event_id'),
												'session_id' => $request->input('session_id') ,
												'product_name' => $request->input('shop_product_name') ,
												//'product_stock' => $request->input('shop_product_stock'),
												'product_max_qty' => $request->input('product_max_qty'),
												'product_price' => $request->input('shop_product_price'),
												'description' => $request->input('description'),
												//'product_sizes' => $product_sizes,
												'product_image' => $name,
												'is_product_has_variant' => $variant,
												'color' => $request->input('color_name_shop'),
												'is_mandatory' => $manda
												]);

				$last_id = DB::getPDO()->lastInsertId();
			}

			// join tables
			$e=$request->input('session_id');
			$u=$user->id;
			$ty = $request->input('event_id');

			$this->setCurrency($request->input('event_id'));

		// UPDATE THE COLOR TABLE WITH THE PRODUCT ID
		/*$MAX_ID = DB::table('tbl_products')
				->where('user_id'  , $user->id)
				->where('session_id'  , $request->input('session_id'))
				->orderBy('id', 'desc')->first();*/

		/*
		DB::table('tbl_shop_color')
			->where('user_id', Auth::user()->id )
			->where('session_id', $request->input('session_id'))
			->where('item_session_id', $request->input('item_session_id'))
			->update([
						'product_id' => $last_id
					]);
		*/

		DB::table('tbl_product_variant')
			->where('item_session_id',$request->input('item_session_id'))
			->update(['product_id'=>$last_id]);

		// SET CURRENCY FOR THE SHOP
		$this->set_shop_symbol($request->input('session_id'));


		$result = DB::table('tbl_products')
						->where('user_id', $user->id)
						->where('session_id', $request->input('session_id') )->get();

		$html = '';

		$html = $this->populateShop($result);

		$msg = array('html'=>$html);
		return response()->json($msg);
	}

	/**
	 *  Populate Shop Product for the event for the edit , call by ajax DURING PAGE LOAD INITITALIZATION
	 */
	public function getEventShop(Request $request){
		$user = Auth::user();
		$r = '';
		$ering = DB::table('tbl_organizer_event')
				->join('tbl_country', 'tbl_organizer_event.country', '=', 'tbl_country.name')
				->where(['tbl_organizer_event.user_id' => $user->id,'tbl_organizer_event.id' => $request->input('event_id') ])
				->get();

			$session_id = $this->getSessionID_ByEventID($request->input('event_id'));

			$this->set_shop_symbol($session_id);

		$result = DB::table('tbl_products')
						->where('user_id', $user->id)
						->where('event_id', $request->input('event_id') )->get();
						$html = $this->populateShop($result);
						return response()->json( array('html'=> $html) );
	}

	/**
	 *  Remove shop item by id
	 */
	public function removeShopByID($to){
		$user = Auth::user();
		DB::table('tbl_products')
					->where('user_id', $user->id)
					->where('id',$to)->delete();

					return response()->json( array('html'=> 'Remove Successfully','status'=>'success') );
	}

   /**
	*  Function for shop population
    */
	public function populateShop($result){
		$html ='';

		foreach($result as $values)
		{
			$title ='';
			$html .= '<div id="shop_parent_id_'.$values->id.'" class="col-md-3 product_item_box" style="padding-right: 0px;">
						 <img class="_shop_item_update_" xid="'.$values->id.'" style="width:100%; height:260px" src="'. url('/').'/uploads/'.$values->product_image.'">
						 <i x-id="'.$values->id.'" id="shop_item_'.$values->id.'" class="remove_item_shop fa fa-close" style="color: #f47a7a;background: #eee;padding: 5px;margin-top: 3px;font-size: 13px;position: absolute;right: 0px;top: -3px;"></i>
				     	<div class="text_product" style="font-weight: 800;text-transform: uppercase;">'.$values->product_name.'</div>
				     	<div class="price"> <strong>'.$this->shop_sign.$values->product_price.'</strong> </div>
				      </div>';
		}

		return $html;
	}

	/**
	 *  Check event exist
	 */
	public function checkEventExist($session_id){
			$user = Auth::user();

			$category = DB::table('tbl_category_events')
		   			 ->where('user_id', $user->id)
		             ->where('session_id', $session_id )->get();
		    $awards = DB::table('tbl_awards')
		   			 ->where('user_id', $user->id)
		             ->where('session_id', $session_id )->get();
		    $map = DB::table('tbl_map')
		   			 ->where('user_id', $user->id)
		             ->where('session_id', $session_id )->get();
		    $a = '';
		     $status = 0;
		    if ($category->isEmpty() )
			{
				$a .= '<li>Category required</li>';
			}

			if ($awards->isEmpty() )
			{
				//$a .= '<li>Awards</li>';
			}

			if ($map->isEmpty() )
			{
				$a .= '<li>Map  required</li>';
			}

			if(!empty($a)){
				  $a = $a;
				  $status = 1;
			}
			$msg = array('html' => $a,'status'=>$status);
			return $msg;
			//return response()->json($msg);
	}

	/**
	 *  SAVE COUPON BOX HERE
	 */
	public function save_coupon_event(Request $c)
	{
		$user = Auth::user();

		// validate first before insert or edit
		$datenow = date("m/d/Y");
		$date_coupon = $c->input('coupon_expiry_date');
		$date_expire = date("m/d/Y", strtotime($date_coupon) );

		$coupon_discount_amount = $c->input('coupon_discount_amount');
		$amount =  $c->input('coupon_amount');
		$error_list = '';

		if($date_expire <= $datenow){
			$error_list .='<li>Check the expiry date</li>';
		}

		if($c->coupon_type != 'byquantity'){
			if($c->email_list ==''){
				$error_list .='<li>Textarea for email list is empty. must be comma separated emails.</li>';
			}
		}

		if( $coupon_discount_amount !== '' ){
			if(is_numeric($coupon_discount_amount)){
			}else{$error_list .='<li>Discount must be valid percent value</li>';}

			if($coupon_discount_amount > 100){
				$error_list .='<li>Discount must be valid percent value less than 100</li>';
			}

		}else{$error_list .='<li>Discount must be valid percent value</li>';}

		$validateSpecial = new Validate();

		$thisIs = $validateSpecial->checkifHasSpecialChar($c->input('coupon_code'));
		$code = $c->input('coupon_code');
		if($thisIs || $code ==''){
			$error_list .='<li>Coupon code must be valid, and no special character</li>';
		}

		if($error_list !=''){
			return response()->json( array('html'=> '<ul style="color:red;text-align:left;">'.$error_list .'</ul>','status'=>'failed'));
		}else {
			if($c->input('xmode_nimo') ==='edit')
			{
				$CHECKIF_EXIST = DB::table('tbl_coupon')
						->where('id', '<>', $c->input('id'))->where('code' , $c->input('coupon_code'))->get();

				if( COUNT($CHECKIF_EXIST) > 0 )
				{
					$error_list ='<li>Coupon exist try again.</li>';
					return response()->json( array('html'=> '<ul style="color:red;text-align:left;">'.$error_list .'</ul>','status'=>'failed'));
				}else{
					DB::table('tbl_coupon')
					->where('event_id', $c->input('event_id'))
					->where('user_id', $user->id)
					->where('id', $c->input('id'))->update(
											['coupon_type' => $c->input('coupon_type') ,
											'code' => $c->input('coupon_code') ,
											'quantity' => $c->input('coupon_quantity'),
											'discount_amount' => $c->input('coupon_discount_amount'),
											'coupon_expiry_date' =>  $c->input('coupon_expiry_date'),
											//'amount' =>  $c->input('coupon_amount'),
											'category'=>$c->input('coupon_category')
											] );
					$this->insertCouponEmailList('email',$c->input('email_list'),$c->input('id'));
				}
			}else
			{
				$CHECKIF_EXIST = DB::table('tbl_coupon')->where('code' , $c->input('coupon_code'))->get();

				if( COUNT($CHECKIF_EXIST) > 0 ){
					$error_list ='<li>Coupon exist try again.</li>';
					return response()->json( array('html'=> '<ul style="color:red;text-align:left;">'.$error_list .'</ul>','status'=>'failed'));
				}else{
				$getid = DB::table('tbl_coupon')->insertGetId(
															['user_id'  => $user->id,
															'event_id' => $c->input('event_id'),
															'coupon_type' => $c->input('coupon_type') ,
															'code' => $c->input('coupon_code') ,
															'quantity' => $c->input('coupon_quantity'),
															'discount_amount' => $c->input('coupon_discount_amount'),
															'coupon_expiry_date' =>  $c->input('coupon_expiry_date'),
															//'amount' =>  $c->input('coupon_amount'),
															'category'=>$c->input('coupon_category'),
															'session_id'=>$c->input('session_id')
															]);
				$this->insertCouponEmailList('email',$c->input('email_list'),$getid);
			}
			}
		}

		$result = DB::table('tbl_coupon')
		    ->where('user_id', $user->id)
		    ->where('session_id', $c->input('session_id') )->get();

			$html = $this->populate_coupon_code($result);
			return response()->json( array('html'=>$html ,'status'=>'success'));
	}


   /**
	*  Insert Coupon Email List
    */
	public function insertCouponEmailList($type , $emailList, $coupon_id)
	{
		if($type=='email')
		{
			//DB::table('tbl_coupon_email_list')->where('coupon_id',$coupon_id)->delete();
			DB::table('tbl_coupon_email_list')
								->where('coupon_id',$coupon_id)
								->where('is_claimed',0)
								->delete();

			$email_list = $emailList;
			$explode_email = explode(",",$email_list);

			if(!empty($explode_email)){
				foreach($explode_email as $values)
				{
					if( $values !='')
					{
							// check if nag exist ba
							$selectni = DB::table('tbl_coupon_email_list')
								->where('coupon_id',$coupon_id)
								->where('is_claimed',0)
								->where('email',$values)->get();

							if($selectni->isEmpty())
							{
								// remove nato daan if naa unya is claim is 0 , then insert again
								DB::table('tbl_coupon_email_list')->insert(
									['coupon_id'  => $coupon_id,
										'email' => $values,
									]);
							}
					}
				}
			}
		}
	}


	// coupon code
	public function populate_coupon_code($result){
		$html = '';
		$title = '';

		$count_result = 0;
		foreach($result as $values)
		{
				$categoryname = $this->getSingleCategoryByID($values->category);
				$html .='<div id="code_new_coupon_'. $values->id .'" class="shop_wrapper_payment_method_coupon code_new_coupon" style="position:relative;margin-bottom: 41px;">
								<span xid-coupon="'. $values->id .'" class="close_button_coupon button_close" style="">x</span>
							    <div class="row">
								     <div class="col-md-3 col-sm-3 mb-4" style="padding-right: 0px;">
								     	<label>Code</label>
								     	<input type="text" readonly value="'.$values->code.'" class="form-control" placeholder="RACEYAYA134" name="">
								     </div>
								    ';

									if($values->coupon_type != 'email'){
										$html .=' <div class="col-md-3 col-sm-3 mb-4" placeholder="30" style="padding-right: 0px;">
										<label>Quantity</label>
										<input type="text" readonly value="'.$values->quantity.'" placeholder="20" class="form-control" name="">
									</div>';
									}

						$html .='<div class="col-md-3 col-sm-3 mb-4" placeholder="150.00" style="padding-right: 0px;">
						<label>% Discount</label>
						<input type="text" readonly value="'.$values->discount_amount.'" placeholder="300" class="form-control" name="">
					</div>
					<div class="col-md-3 col-sm-3 mb-4"  style="padding-right: 0px;">
								     	<label>Expiry Date</label>
								     	<input type="text" readonly value="'.$values->coupon_expiry_date.'" class="form-control" placeholder="10/10/2019" name="">
								     </div>
							    </div>
							     <div class="row">

								     <div class="col-md-3 col-sm-3" style="padding-right: 0px;">
								     	<label>Category</label>
								     	<input type="text" readonly value="'.$categoryname.'" class="form-control" placeholder="All" name="">
								     </div>
							    </div>
							    <div class="row" style="margin-top: 40px; ">
							    	<div class="col-md-2" style="padding-right: 0px;">
								     	<span x-id="'.$values->id.'"  class="editCouponmodal" style="background: #eee;display: block;text-align: center;padding: 18px;">Edit Info</span>
								    </div>
								</div>
							</div>';

		}
		return $html;
	}

	/*
	 Delete Coupon Code,Delete Coupon Code
	 */
	public function delete_coupon(Request $request)
	{
		$user = Auth::user();
		$session_id = $request->input('session_id');
		$id = $request->input('id');
		$count = 0;

		DB::table('tbl_coupon')
		     ->where('user_id', $user->id)
		     ->where('id', $id)
			 ->where('session_id', $session_id)->delete();

			 $result = DB::table('tbl_coupon')
			 ->where('user_id', $user->id)
			 ->where('session_id', $request->input('session_id') )->get();

			 if(!$result->isEmpty()){
				 foreach($result as $v){
					$count++;
				 }
			 }

		 	$msg = $this->populate_coupon_code($result);
			return response()->json(array('count'=>$count,'html'=>$msg));
	}

	/**
	 *  GET COUPON WHEN EDITING
	 */
	public function getCouponbyid(Request $request){
		$user = Auth::user();
		$result = DB::table('tbl_coupon')
					->where('user_id', $user->id)
					->where('id', $request->input('id'))
					->where('session_id', $request->input('session_id') )->get();

		$data = array();
		$html_email = '';

		$get_coupon_type = '';
		$html_email_list = '';
		$html_email_list3 ='';
		if(!$result->isEmpty())
		{
			foreach($result as $values)
			{
				$data = (array)$values;
				$get_coupon_type = $values->coupon_type;
			}

			if($get_coupon_type ==='email'){
				$get = DB::table('tbl_coupon_email_list')
					   ->where('coupon_id', $request->input('id') )->get();

				$count=0;
				if(!$get->isEmpty()){
					foreach($get as $email_list)
					{
						if($count==0){
							$html_email_list .=$email_list->email;
						}else{
							$html_email_list .=','.$email_list->email;
						}

						/*
						if($count==0){
							$html_email_list .=  '<div class="col-md-8 col-sm-8 assign_email_row mb-4" style="padding-right: 0px;">
														<label for="">Coupon assigned to emails below</label>
														<div class="d" style="display:flex">
															<input value="'.$email_list->email.'" type="text" class="form-control byemail_coupon coupon_element_email" name="" style="background: rgb(238, 238, 238) none repeat scroll 0% 0%;"><span class="byemail_insert"><i style="position: relative;top: 5px;left: 9px;color: green;" class="addByEmail fa fa-plus"></i></span>
														</div>
												  </div>';
						}else{
							$html_email_list .=  '<div class="col-md-8 col-sm-8 assign_email_row_insert mb-4" style="padding-right: 0px;">
														<div class="d" style="display:flex">
															<input  value="'.$email_list->email.'" type="text" class="form-control byemail_coupon coupon_element_email" name="" style="background: rgb(238, 238, 238) none repeat scroll 0% 0%;"><span class=""><i style="position: relative;top: 5px;left: 9px;color: red;" class="addByEmailremove fa fa-trash"></i></span>
														</div>
												  </div>';
						}*/
						$count++;
					}
				}
			}
		}

		if($html_email_list !=''){
			$html_email_list3 =  '<div class="col-md-8 col-sm-8 assign_email_row_insert mb-4" style="padding-right: 0px;">
			<div class="sub-heading"><h6><strong>Coupon assigned to emails below, comma separated</strong></h6></div><span style="font-size:12px;">myemail@gmail.com,youremail@gmail.com</span>
										<div class="d" style="display:flex">
															<textarea  type="text" class="form-control byemail_coupon coupon_element_email" name="" style="background: rgb(238, 238, 238) none repeat scroll 0% 0%;">'.$html_email_list.'</textarea>
														</div>
												  </div>';
		}
		$msg = array('data' => $data,'html'=> $html_email_list3);
		return response()->json($msg);
	}

	public function addShippingOption(Request $request){
		$user = Auth::user();
		DB::table('tbl_shipping_option')->insert(['user_id'  => $user->id,
										 'event_id' => $request->input('event_id'),
										 'shipping_name' => $request->input('name') ,
										 'shipping_amount' => $request->input('price'),
										 'session_id'=>$request->input('session_id')
										]);
		$result = DB::table('tbl_shipping_option')
		    ->where('user_id', $user->id)
		    ->where('session_id', $request->input('session_id') )->get();


		$html = $this->shipping_option_html($result);

		$msg = array('html' => $html);
		return response()->json($msg);
	}

	/**
	 *  Delete Shipping Option
	 */
    public function deleteShippingOption(Request $request)
    {
  		$user = Auth::user();
		$session_id = $request->input('session_id');
		$id = $request->input('id');

		$delete = DB::table('tbl_shipping_option')
		     ->where('user_id', $user->id)
		     ->where('id', $id)
		     ->where('session_id', $session_id)->delete();
    	 if($delete){
			$msg = array('status'=>1,'smg' => 'Shipping Deleted Sucessfully');
			return response()->json($msg);
    	 }else{
    	 	$msg = array('status'=>0,'smg' => 'Failed to remove shipping');
			return response()->json($msg);
    	 }

    }

	/**
	 *   Shipping Option Html
	 */
    public function shipping_option_html($result){
		$html = '';
		$title = '';
		foreach ($result as $key => $value) {
			$html .= '<div class="customdiv" style="position:relative;padding-right: 0px;margin-left:16px !important">
						<span x-id-shipping-option="'.$value->id.'" class="close_button_shipping_option button_close" style="">x</span>
						<span class="cl circle_shipping"></span>
						<span class="shipping_name">'.$value->shipping_name.'</span>
						<div class="shipping_details">
							<span class="shipping_details_price">Shipping</span>
							<span class="price">'.$value->shipping_amount.'</span>
						</div>
					</div>';
		}

		return $html;
   }

   /**
	*  Remove, Remove
    */
   public function remove($id){
   		$user = Auth::user();
		$user_id = $user->id;

			/** Organizer Event */
			DB::table('tbl_organizer_event')
			->where('user_id',$user_id)
			->where('id', $id)->delete();

			/** Additional  Event */
			DB::table('tbl_additional_question')
			->where('user_id',$user_id)
			->where('event_id', $id)->delete();

			/** Awards  Event */
			DB::table('tbl_awards')
			->where('user_id',$user_id)
			->where('event_id', $id)->delete();

			/** Category  Event */
			DB::table('tbl_category_events')
			->where('user_id',$user_id)
			->where('event_id', $id)->delete();

			/** Coupon  Event */
			DB::table('tbl_coupon')
			->where('user_id',$user_id)
			->where('event_id', $id)->delete();

			/** Map  Event */
			DB::table('tbl_map')
			->where('user_id',$user_id)
			->where('event_id', $id)->delete();

			/** shipping Option  Event */
			DB::table('tbl_shipping_option')
			->where('user_id',$user_id)
			->where('event_id', $id)->delete();

			return redirect()->route('profile');
    }

	/**
	 *  Ad Organizer Event
	 */
	public function addOrganizerEvent(Request $request)
	{
		$user = Auth::user();

		// check if tbl_organizer_event exist
		// JUST UPDATE THE TABLE ALREADY EXIST
		// ASA DAPIT ANG SUNOG SA SAVE BUTTON BA
		if($request->input('firelocation') =='savebutton' ){
			$check = new Validate();
			$field_errors = '';
			$htmlreturn = $check->checkISempty($request) ;

			if($htmlreturn['status']){
				DB::table('tbl_organizer_event')
					->where('id', $request->input('event_id'))
					->where('user_id', $user->id)
					->where('session_id', $request->input('session_id'))->update(
						['payment_method'=> $request->input('payment_method_name'),
						 'event_name' => $request->input('event_name'),
						 'event_date_race' => $request->input('daterace'),
						 'event_race_type' => $request->input('racetype'),
						 'event_reg_close_month' => $request->input('reg_close_month'),
						 'event_reg_close_day' => $request->input('reg_close_day'),
						 'event_reg_close_time' => $request->input('reg_close_hour'),
						 'event_description' => $request->input('event_description'),
						 'country' => $request->input('event_country'),
						 'city_town' => $request->input('event_town'),
						 'state' => $request->input('event_state'),
						 'zip' => $request->input('event_zip'),
						 /* 'create_event_status' => 0, */
						 'organizer_term_conditions' => $request->input('organizer_term_condition'),
						 'payment_method_serialize' => serialize($_POST['payment_method'])
						]
					);
			}else{
				return response()->json($htmlreturn);
			}


		}else{

			// IF SUNOG TOA SA SUBMIT BUTTON
			// what is pag edit unya ni anhi diri
			if( $request->input('mode') =='edit' )
			{
					DB::table('tbl_organizer_event')
					->where('id', $request->input('event_id'))
					->where('user_id', $user->id)
					->where('session_id', $request->input('session_id'))->update(
						['boosttype' =>$request->input('boosttype'),
						//'create_event_status' => 1,
						//'create_event_status' => 0,
						'event_submit_status' => 1,
						'payment_method_serialize' => serialize($_POST['payment_method']),
						'payment_method'=> $request->input('payment_method_name'),
						//'cover_processing_fee' => $request->input('cover_processing_fee'),
						'organizer_term_conditions' => $request->input('organizer_term_condition'),
						'term_and_contidions'=> 1]
					);
			}else{
				// needs approval para ang create_event_status == 1
				DB::table('tbl_organizer_event')
					->where('id', $request->input('event_id'))
					->where('user_id', $user->id)
					->where('session_id', $request->input('session_id'))->update(
						['boosttype' =>$request->input('boosttype'),
						//'create_event_status' => 0,
						'payment_method_serialize' => serialize($_POST['payment_method']),
						'event_submit_status' => 1,
						'payment_method'=> $request->input('payment_method_name'),
						//'cover_processing_fee' => $request->input('cover_processing_fee'),
						'organizer_term_conditions' => $request->input('organizer_term_condition'),
						'term_and_contidions'=> 1]
					);
			}
	    }

		$msg = array('status'=>1,'smg' => 'Sucessfully saved');
		return response()->json($msg);
 	}

	 /**
	  * Get shipping name
	  */
	public function getShippingName(){
		$html = '';
		$html = '<div class="customdiv" style="position:relative;padding-right: 0px;margin-left:16px !important">
					<span xid-coupon="53" class="close_button_coupon button_close" style="">x</span>
					<span class="cl circle_shipping"></span><span class="shipping_name">LBC</span>
					<div class="shipping_details">
						<span class="shipping_details_price">Shipping</span>
						<span class="price">200</span>
					</div>
				</div>';
	}

	/**
	 *  Event details in the front-end
	 *  @param1 = event id
	 *
	 */
	public function view_event_racer_details($eventid)
	{
		$user = Auth::user();
		if($user){
			if(Auth::user()->id == 1){
				$result = 	DB::table('tbl_organizer_event as t')
							  ->select("t.*","c.name as name")
							  ->join('users as c', 't.user_id', '=', 'c.id')							
							   ->where(['t.id'=> $eventid,'t.create_event_status'=> 1])
							  ->get();
			}else{

				$result = DB::table('tbl_organizer_event as t')
				->select("t.*","c.name as name")
				->join('users as c', 't.user_id', '=', 'c.id')
				 ->where(['t.id'=> $eventid])
				 //->where(['t.id'=> $eventid,'t.create_event_status'=> 1])
				->get();
			}
		}else{
			$result = DB::table('tbl_organizer_event as t')
			->select("t.*","c.name as name")
			->join('users as c', 't.user_id', '=', 'c.id')
			->where(['t.id'=> $eventid])
			//->where(['t.id'=> $eventid,'t.create_event_status'=> 1])
			->get();
		}
		$d = 'span';
        $kami 	  = '';
        $username = '';
		$eventid  = $eventid;

		$get_category = DB::table('tbl_category_events')
						->where('event_id',$eventid)->get();

		$ulcatsrates  = '';
		$allcats      = '';
		$cat_currency = '';

		$total_event_registered_racer = DB::table('tbl_racer_registration')
                                   ->where('event_id',$eventid)
                                   ->where('registration_submit_status',1)
                                   ->where('status',1)->count();

        $total_maxallocated_participants = DB::table('tbl_category_events')
                                   ->where('event_id',$eventid)->sum('max_participants');

		if(!$get_category->isEmpty())
		{
			foreach($get_category as $catss)
			{
				$ulcatsrates  = '';
				$name_currency = DB::table('tbl_country')->where('name',$catss->currency)->get();

				if(!$name_currency->isEmpty())
				{
					foreach($name_currency as $cattts)
					{
						$cat_currency = $cattts->currency;
					}
				}else{
					$cat_currency = '';
				}

				$ulcatsrates .= '<ul class="allCategory_events" style="display:flex;flex-wrap: wrap;margin:10px;font-size:12px;padding-left:0px;"><li><strong>Category Name</strong> <div>' .$catss->category_name.'</div></li>';
				$ulcatsrates .= '<li>Early Bird Rate:<div><strong>'.$cat_currency. ' '. $catss->cat_local_early_bird_rate .'.00</strong></div></li>';
				$ulcatsrates .= '<li>Reg Rate: <div><strong>'.$cat_currency. ' '. $catss->cat_local_reg_rate .'.00</strong></div></li>';
				$ulcatsrates .= '<li>Late Reg Rate: <div><strong>'.$cat_currency. ' '.$catss->cat_local_late_reg_rate .'.00</strong></div></li>';

				$ulcatsrates .= '<li>Int. Bird Rate: <div><strong>USD '.$catss->int_early_bird_rate_amount .'.00</strong></div></li>';
				$ulcatsrates .= '<li>Int. Reg Rate: <div><strong>USD '.$catss->int_regular_rate_amount .'.00</strong></div></li>';
				$ulcatsrates .= '<li>Int. Late Reg Rate: <div><strong>USD '.$catss->int_late_reg_rate_amount .'.00</strong></div></li></ul>';
			}

			$allcats .= $ulcatsrates;
		}

		return view('racer-event-details',compact('allcats','result','username','eventid','total_event_registered_racer','total_maxallocated_participants','user'));
	}

	/** */
	public function get_action_registration(){
		echo 'test';
		die();
	}

	/**
	 *  View event details in organizer, ORGANIZER ONLY CAN ASSIST
	 */
	public function view_event_details($eventid,$catid = 0)
	{
		$user = Auth::user();
		if($user->user_type == 3){
			return redirect('/profile');
		}

		if(isset($_GET['exp'])){

				$resultss  = DB::table('tbl_racer_registration')
							->where('event_id', $eventid)
							->where('organizer_id',$user->id)
							->where('action_type', 'register' )
							->where('registration_submit_status', 1 )->get();

				$delimiter = ",";
				$filename  = "APPLICANTS-CAT-ID-".$eventid . '-('.date('Y-m-d') . ").csv";
				$location  = '';

				if( count($resultss) > 0)
				{
					header('Content-type: text/csv');
					header('Content-Disposition: attachment; filename="'.$filename.'"');
					header('Pragma: no-cache');
					header('Expires: 0');

					// clean output buffer
					ob_end_clean();

					$f = fopen('php://output', 'w');

					$title = array('Table Registration');

					$fields = array( 'First Name',
									 'Last Name',
									 'Email',
									 'Zip',
									 'City',
									 'State',
									 'Phone' ,
									 'Address',
									 'Gender',
									 'Country',
									 'Nationality',
									 'Status' ,
									 'Registration Type' ,
									 'Bank Name' ,
									 'Bank Card Holder',
									 'Referrence Number',
									 'Deposited Amount',
									 'Credit card code',
									 'Credit card number',
									 'Credit card expiry',
									 'Credit Card holder'
									);

						fputcsv($f, $fields, $delimiter);

						//output each row of the data, format line as csv and write to file pointer
						foreach($resultss as $row)
						{

							if($row->status ==0){
								$status = 'Pending';
							}  else if($row->status == 1){
								$status = 'Paid';
							}  else if($row->status == 2){
								$status = 'Registered';
							}  else if($row->status == 3){
								$status = 'Submitted';
							}

							$lineData = array(  $row->firstname,
												$row->lastname,
												$row->email,
												$row->zip,
												$row->city,
												$row->state,
											//	$row->password,
												$row->phone,
												$row->address,
												//$row->username,
												//$row->date_birth,
												$row->gender,

												$row->country,
												$row->nationality,
												$status,
												$row->registration_type ,
												$row->submit_bank_name ,
												$row->submit_deposit_name,
												$row->submit_reference_number,
												$row->submit_amount_deposited,

												/*$row->card_code,
												$row->card_number,
												$row->card_expiry,
												$row->card_holder*/

											);
							fputcsv($f, $lineData, $delimiter);
						}
					fclose( $f );
					exit;
				}

		}


        $result = DB::table('tbl_organizer_event')
                  ->where('user_id', $user->id)
                  ->where('id', $eventid)
                  ->where('event_submit_status', 1 )->get();

		$organize_ref = DB::table('tbl_organizer_event as t')
				->join('users as c', 't.user_id', '=', 'c.id')
				->where('t.id', $eventid)->first();
		$organizedby = 0;
		if($organize_ref){
			$organizedby = $organize_ref->name;
		}


        $kami 	  = '';
        $username = '';
        $eventid  = $eventid;

		// NEW CODE TO GET ALL PARTICIPANTS
		$allparticipants = $this->getAlleventparticipants($catid,$eventid);

		// NEW CODE TO GET THE CATEGORY OF THE EVENTS
		$category_results = DB::table('tbl_category_events')
								->where('user_id', $user->id)
								->where('event_id', $eventid)->get();
		$catid = $catid;
		return view('organizer-event-view',compact('organizedby','catid','category_results','allparticipants','result','username','eventid', 'user'));
	}

	/**
	 *  Get all participants for the events under organizer end
	 */
	public function getAlleventparticipants($c = 0,$eventid)
	{
		// CONNECT TWO TABLES CATEGORY AND REGISTRATION
		$queryString = 'vv';
		$pm 		 = 'Paypal';
		$user = Auth::user();

		if(!empty($_POST))
		{
			if(isset($_POST['status_action']))
			{
				$st = $_POST['status_action'];
				if(!empty($_POST['checkbox']))
				{
					$post = $_POST['checkbox'];
					foreach($post as $vv){
						if($st==4){
							DB::table("tbl_racer_registration")
							->where('id', $vv)->update( ['status' => $st ]);
						}else{
							DB::table("tbl_racer_registration")
							->where('id', $vv)->update( ['status' => $st ]);
						}
					}
				}
			}
		}

		$query = DB::table('tbl_racer_registration');
		$query->join("tbl_category_events","tbl_racer_registration.category_id","=","tbl_category_events.id");
		$query->select("tbl_racer_registration.*");
		$query->where("tbl_racer_registration.status",'<>',4);
		$query->where("tbl_racer_registration.organizer_id",$user->id);

		if($c==0)
		{
			$query->where("tbl_racer_registration.event_id", $eventid);
		}else{
			$query->where("tbl_racer_registration.event_id", $eventid);
			$query->where("tbl_racer_registration.category_id", $c);
		}

		if(isset($_POST['ds']))
		{
			if($_POST['ds'] !='')
			{
				if($_POST['ds']=='1m'){
					$date =  date("Y-m-d", strtotime("first day of this month"));
				}else if($_POST['ds']=='-1m'){
					$date = date('Y/m/d', strtotime('- 1 months'));
				}else if($_POST['ds']=='-2m'){
					$date = date('Y/m/d', strtotime('- 2 months'));
				} else if($_POST['ds']=='-3m'){
					$date = date('Y/m/d', strtotime('- 3 months'));
				} else if($_POST['ds']=='-1year'){
					$date = date("Y",strtotime("-1 year"));
				}
				$query->where(DB::raw("(DATE_FORMAT(date_registered,'%Y/%m/%d'))"), ">=", $date );
			}
		}

		/* REGISTRATION STATUS */
		if(isset($_POST['registration_status'])){
			if($_POST['registration_status'] !='All'){
				$registration_status = $_POST['registration_status'];
				$query->where("tbl_racer_registration.status",$registration_status);
			}
		}

		// PAYMENT METHOD
		if(isset($_POST['pm']))
		{
			if($_POST['pm'] !='All')
			{
				$pm = $_POST['pm'];
				$query->where("tbl_racer_registration.payment_method_name", 'LIKE', "%$pm%");
			}
		}

		if(isset($_POST['search']))
		{
			if($_POST['search'] !='')
			{
				$search = $_POST['search'];
				$query->where("tbl_racer_registration.firstname", 'LIKE', "%$search%");
				$query->orwhere("tbl_racer_registration.lastname", 'LIKE', "%$search%");
				$query->orwhere("tbl_racer_registration.email", 'LIKE', "%$search%");
			}
		}

		$result = $query->paginate(20);
		return  $result ;
	}

	/**
	 *  Result event
	 */
	public function result_event($e){
		return view('result-event-details');
	}

	/**
	 *  Get Event Map List
	 */
	public function getEventMapList(Request $request){
		  $user = Auth::user();
		   $all  = DB::table('tbl_map')
						->where('user_id', $user->id)
						->where('event_id',$request->input('event_id') )->get();

			$html = $this->populateEventMap($all);
			$msg  = array('html'=> $html['html'] , 'msg'=>'Save Map Code Sucessfully');
			return response()->json($msg);
	}

	/**
	 *  Get Awards List
	 */
	public function getEventAwardList(Request $request){
		$user = Auth::user();
		 $all  = DB::table('tbl_awards')
				  ->where('user_id', $user->id)
				  ->where('event_id',$request->input('event_id') )->get();

		  $html = $this->getAllAwards($request , $type = 'html');
		  $msg  = array('block'=> $html['block'] , 'msg'=>'Save Map Code Sucessfully');
		  return response()->json($msg);
	}

	 /**
	  *  Get All event question
	  */
    public function getEventQuestion(Request $request){
		 $user = Auth::user();
		 $all  = DB::table('tbl_additional_question')
				  ->where('user_id', $user->id)
				  ->where('event_id',$request->input('event_id') )->get();
		  $html = $this->populate_question_html($all);
		  $msg  = array('html'=> $html , 'msg'=>'Retrieved question successfully');
		  return response()->json($msg);
	}

	/**
	 *  Update all tables
	 */
	public function update_tables_with_events($data , $tables){
		foreach($tables as $values ){
			DB::table($values)
			->where('user_id', $data['user_id'])
			->where('session_id',$data['session_id'])->update( ['event_id' => $data['event_id'] ]);
		}
		return 1;
	}

	/**
	 *  Query tables
	 */
	public function query_tables($tables, $id){
		$user = Auth::user();
		$query  = DB::table($tables)
				 ->where('user_id', $user->id)
				 ->where('event_id',$id )->get(); return $query;
	}

	// Use for organizer Authenticated method
	public function call_event_details(Request $f)
	{
		$type = $f->input('type');

		// is auth
		$is_auth = $f->input('auth');

		$user = Auth::user();
		$replace = \str_replace("_event_view_","",$type);
		$html = '';

		switch($replace){
			case "shop_":

				if($is_auth == 0){
					$query_table =  DB::table('tbl_products')
									 ->where('event_id',$f->input('eid') )->get();
				}else{
					//$query_table = $this->query_tables('tbl_products', $f->input('eid'));
					$query_table =  DB::table('tbl_products')
									 ->where('user_id', $user->id)
									 ->where('event_id',$f->input('eid') )->get();
				}

				$type_html = 0;
				 foreach($query_table as $v){
					$html .='<div class="col-md-3 col-sm-3" style="margin:12px;">
								<div img="shopimg"><img style="width:100%;height:179px;" src="'.url('/').'/uploads/'. $v->product_image.'"/></div>
								<div class="name_of_product">'.$v->product_name.'</div>
								<div class="name_of_price">'.$v->product_price.'</div>
							 </div>';
				 }

				 $html ='<div class="row">'.$html.'</div>';
			break;

			case "racemap_":
				if($is_auth == 0)
				{
					$query_table  = DB::table('tbl_map')
					->where('event_id',$f->input('eid') )
					->get();
				}else{
					$query_table  = DB::table('tbl_map')
					->where('user_id', $user->id)
					->where('event_id',$f->input('eid') )
					->get();
				}

				$html 	   = '';
				$type_html = 0;

				foreach($query_table as $cv)
				{
					if($cv->map_image =='')
					{
						$type_html = 1;
						$html .=  '<div style="margin-bottom:15px;margin-top:15px;"><h4>'.$cv->map_name.'</h4>'.$cv->map_google_code.'</div>';
					}else{
						$html .=  '<div style="margin-bottom:15px;margin-top:15px;"><h4>'.$cv->map_name.'</h4>'.'<img style="width:100%" src="'. url('/'). '/'.$cv->map_image .'"/></div>';
					}
				 }

			break;

			case "participants_":

				$query_table = DB::table('tbl_category_events')
							->where('tbl_category_events.user_id', $user->id)
							->where('tbl_category_events.event_id', $f->input('eid'))->get();

				$table_inner = '';
				$html = '';
				$list_top = '';
				$count = 0;
				if(!$query_table->isEmpty())
				{
					$thead = '<thead>
								<tr>
									<th>ID</th>
									<th>First Name</th>
									<th>Last Name</th>
									<th>Gender</th>
									<th>Category</th>
								</tr>
							  </thead>';

					foreach($query_table as $values_racer)
					{
						if($count == 0){
							$list_top .= '<li x-cat-id="'.$values_racer->id.'"  class="first_cat">'. $values_racer->category_name .'</li>';
						}else{
							$list_top .= '<li x-cat-id="'.$values_racer->id.'"  class="'.$count.'">'. $values_racer->category_name .'</li>';
						}

						$count++;
					}

				}

				if(!empty($list_top)){
					$html = '<ul class="event_ul_participants_sublist" style="display:flex;flex-wrap:wrap">'.$list_top.'</ul><div class="holder-table-list"></div>';
				}

			break;

			case "description_":
				if($is_auth == 0){
					$query_table  = DB::table('tbl_organizer_event')
					//->where('user_id', $user->id)
					->where('id',$f->input('eid') )->get();
				}else{
					$query_table  = DB::table('tbl_organizer_event')
					->where('user_id', $user->id)
					->where('id',$f->input('eid') )->get();
				}

				foreach($query_table as $v ){
					$html = $v->event_description;
				}

			break;

			case "awards_":

				if($is_auth == 0){

					$query_table =  DB::table('tbl_awards')->where('event_id',$f->input('eid') )->get();
				}else{

					$query_table =  DB::table('tbl_awards')
					->where('user_id', $user->id )
					->where('event_id',$f->input('eid') )->get();
				}

				$html = '<div class="col-md-3 mb-4 block_box_award mt-20"> <p class="text-center">No Awards Listed</p> </div>';
				$ul_list_holder  = '';
				if(!$query_table->isEmpty()){
					foreach($query_table as $values)
					{
						$unser = base64_decode($values->list_items);

						$unseree = unserialize($unser);

						$ul_list_holder =  $this->award_list_builder($unseree);

						$html .= '<div class="col-md-3 mb-4 block_box_award">
									<div class="imgawards"><img src="'.url('/').'/uploads/'.$values->awards_image.' "></div>
									<div><h6><strong>'.$values->awards_name.'</strong></h6></div>
									'.$ul_list_holder.'

								</div>';

					}
			}
			break;
		}

		$event_fire  = array('html'=> $html , 'msg'=>'Retrieved question successfully');
		return response()->json($event_fire);
	}

	/**
	 *   Build list for award
	 */
	public function award_list_builder($unser){
		$LIST_HOLDER = '';
		$list = '';
		foreach($unser as $v)
		{
			$ul_list ='<label for="racetype">'.$v['title'].'</label>';

			$explode = explode(',', $v['name']);

			if( sizeof($explode) == 0 )
			{
				$list = $explode[0];
			}else{
				foreach ($explode as $key => $value) {
					$list .='<li>'.$value.'</li>';
				}
			}

			$LIST_HOLDER .= $ul_list . '<ul>'.$list.'</ul>';

		}

		return $LIST_HOLDER;
	}

	/**
	 *  Ajax get coupon code during init
	 */
	public function getCouponCode(Request $i){
		$user = Auth::user();
		$result = DB::table('tbl_coupon')->where('user_id', $user->id)->where('event_id', $i->input('event_id') )->get();

		$html = $this->populate_coupon_code($result);
		return response()->json( array('html'=> $html , 'msg'=>'Retrieved coupon successfully') );
	}

	/**
	 *  Awards Remove
	 */
	public function awardsRemove($ev,$xid){
		$user = Auth::user();

		if($ev == 0){
			$result = DB::table('tbl_awards')
			->where('id', $xid)
			->where('user_id', $user->id)
			->delete();
		}else{
			$result = DB::table('tbl_awards')
			->where('id', $xid)
			->where('user_id', $user->id)
			->Where('event_id', $ev )->delete();
		}

		return response()->json( array('html'=> '' , 'msg'=>'Deleted awards successfully') );
	}

	public function getShippingOption(Request $i){
		$user = Auth::user();
		$result = DB::table('tbl_shipping_option')->where('user_id', $user->id)->where('event_id', $i->input('event_id') )->get();

		$html = $this->shipping_option_html($result);
		return response()->json( array('html'=> $html , 'msg'=>'Retrieved shipping successfully') );
	}

	public function getAwardbyid($ev,$id,$token_id){
		$user = Auth::user();

		$result = DB::table('tbl_awards')
		->where('id', $id)
		->where('user_id', $user->id)
		->where('session_id', $token_id)
		->where('event_id', $ev )->get();

		$awards_list = '';
		$html = '';
		$array_awards = array();
		$count = 0;
		$image_name = '';
		$award_name = '';

		foreach($result as $v)
		{
			$image_name = url('/'). '/uploads/'.$v->awards_image;
			$award_name = $v->awards_name;
			$unser 	 = base64_decode($v->list_items);
			$unseree = unserialize($unser);

			for($i=0 ; $i < sizeof($unseree) ; $i++)
			{
				$remove = ($i == 0) ? "": '<label>List Item Title</label><span class="close_item_add_awards" style="">x</span>';

				$html .='<div id="wrapper_id_'.$count.'" class="wrapper_item" style="margin-bottom:12px;padding:10px;border:1px solid #ddd">
									<div class="row" style="margin-right: 8px;">
										<div class="col-md-12" style="padding: 12px;margin-left: 12px;">
											'.$remove.'
											<input placeholder="1st Place" value="'.$unseree[$i]['title'].'" type="text" class="form-control list_item_title" name="list_item_[0][title]">
										</div>
									</div>
									<div class="row" style="margin-right: 8px;">
										<div class="col-md-12" style="padding: 12px;margin-left: 12px;">
											<label>List Item Name</label>
											<input value="'.$unseree[$i]['name'].'"  placeholder="1000,Finisher Medal,Unisex T-shirt" type="text" class="form-control list_item_name" name="list_item_[0][name]">
										</div>
									</div>
								</div>';
			}
		}

		return response()->json( array('image_name'=>$image_name,'award_name'=>$award_name,'html'=> $html , 'msg'=>'Retrieved Awards successfully') );
	}

	/**
	 *  Set the currency Symbol
	 */
	public function setCurrency($event_id){
		$user = Auth::user();
		$ering =	DB::table('tbl_organizer_event')
						->join('tbl_country', 'tbl_organizer_event.country', '=', 'tbl_country.name')
						->where(['tbl_organizer_event.user_id' => $user->id,'tbl_organizer_event.id' =>$event_id])
						->get();

		if(!$ering->isEmpty()){
			foreach($ering as $bbb){
				$this->currency_symbol = $bbb->symbol;
			}
		}else{
			$this->currency_symbol = '&#36;';
		}
	}

    /**
	 *  Set Currency By Cats
	 */
	public function getCurrencyByCats(){
		$catsID = $this->current_cat_id;
		$user   = Auth::user();
		$ering  = DB::table('tbl_category_events')
				->join('tbl_country', 'tbl_category_events.currency', '=', 'tbl_country.name')
				->where(['tbl_category_events.user_id' => $user->id,'tbl_category_events.id' => $catsID])
				->get();

		if(!$ering->isEmpty())
		{
			foreach($ering as $bbb)
			{
				if( $bbb->symbol =='')
				{
					$this->current_cat_currency = '&#8369;';
				}else{
					$this->current_cat_currency = $bbb->symbol;
				}
			}
		}else{
			$this->current_cat_currency = '&#8369;';
		}
	}

	/*
	 *  Return currencty, FOR POPULATE CATS
	 *  return default dollar if the currency is empty
	 */
	public function getCurrentrequestCat($catsID){
		$user   = Auth::user();
		$ering  = DB::table('tbl_category_events')
				->join('tbl_country', 'tbl_category_events.currency', '=', 'tbl_country.name')
				->where(['tbl_category_events.user_id' => $user->id,'tbl_category_events.id' => $catsID])
				->get();

		$value = '';

		if(!$ering->isEmpty())
		{
			foreach($ering as $bbb)
			{
				if( $bbb->symbol =='')
				{
					$value = '&#8369;';
				}else{
					$value = $bbb->symbol;
				}
			}
		}else{
			$value = '&#8369;';
		}

		return $value;
	}

	/**
	 *   @PARAM1= SESSION_ID
	 */
	public function set_shop_symbol($r){
		$user   = Auth::user();
		$tbl_category_events =	DB::table('tbl_category_events')
								->join('tbl_country', 'tbl_category_events.currency', '=', 'tbl_country.name')
								->where(['tbl_category_events.user_id' => $user->id,'tbl_category_events.session_id' => $r ])
								->get();

		if(!$tbl_category_events->isEmpty())
		{
			foreach($tbl_category_events as $v)
			{
				$this->shop_sign = $v->symbol;
			}
		}
	}

	/**
	 *   GET SESSION_ID BY EVENT_ID FOR BACKEND ONLY
	 *   RETURN SESSION ID
	 */
	public function getSessionID_ByEventID($event_id)
	{
		$tbl_organizer_event =	DB::table('tbl_organizer_event')
								->where(['tbl_organizer_event.id' => $event_id])
								->get();
		if(!$tbl_organizer_event->isEmpty()){
			foreach($tbl_organizer_event as $v){
					return $v->session_id;
			}
		}
	}


	/*
	 *   GET CATEGORY CURRENCY NAME param session
	 *   RETURN category currency name
	 */
	public function getCategoryCurrencyName($r)
	{
		$user   = Auth::user();

		$tbl_category_events =	DB::table('tbl_category_events')
								->where('tbl_category_events.user_id', $user->id)
								->where('tbl_category_events.session_id' , $r )
								->get();

		if(!$tbl_category_events->isEmpty())
		{
			foreach($tbl_category_events as $v)
			{
				$currency_name = $v->currency;
			}
			return $currency_name;
		}else{
			return '';
		}
	}


	/**
	 *  Get single category id
	 */
	public function getSingleCategoryByID($catid){
		$user   = Auth::user();
		$tbl_category_events =	DB::table('tbl_category_events')
								->where('tbl_category_events.user_id', $user->id)
								->where('tbl_category_events.id' , $catid )
								->get();

		if(!$tbl_category_events->isEmpty()){
			foreach($tbl_category_events as $v){
				$currency_name = $v->category_name;
			}

			return $currency_name;
		}else{
			return '';
		}
	}

	/**
	 *  Get the participants , in the left menu under view details
	 */
	public function getparticipants($catid)
	{
		$user = $user   = Auth::user();
		$select = "SELECT tbl_racer_registration.* ,tbl_category_events.category_name
		FROM tbl_racer_registration
		LEFT JOIN tbl_category_events
		ON tbl_racer_registration.category_id = tbl_category_events.id
		where tbl_racer_registration.organizer_id =$user->id and tbl_racer_registration.category_id =$catid";

		$query_table = DB::select($select);

		  $html = '';
		  $list_top = '';
		  $table_inner = '';

		  if( count($query_table)>0)
		    {
			  $thead = '<thead>
						  <tr>
							  <th>ID</th>
							  <th>First Name</th>
							  <th>Last Name</th>
							  <th>Gender</th>
							  <th>Category</th>
							  <th>Option</th>
						  </tr>
						</thead>';
			  $count = 0;
			  foreach($query_table as $values_racer)
			  {
					  	$table_inner .='<tr>
											  <td>'.$values_racer->id.'</td>
											  <td>'.$values_racer->firstname .'</td>
											  <td>'.$values_racer->lastname.'</td>
											  <td>'.$values_racer->gender.'</td>
											  <td>'.$values_racer->category_name.'</td>
											  <td><span class="hover_details_racer_registration_table" style="background: #eee;padding: 6px;font-size: 12px;" xid="'.$values_racer->id.'"class="view_registration_racer_details">View Detail</span></td>
										  </tr>';

				  $count++;
			  }

			    if(!empty($table_inner)){
					$html = $list_top. '<table class="table">'.$thead . '<tbody>'.$table_inner.'</tbody>'.'</table>';
			    }
		  }

		return response()->json( array('html'=> $html, 'msg'=>'Retrieved shipping successfully') );
	}

	/**
	 *  Get Order Items
	 */
	public function getOrderItems()
	{
					$user = Auth::user();

					// GET THE NAME
					$user_firstname =  Auth::user()->first_name;

					// HINDI NA GINAMIT ANG REG SHOP
					$sql = "SELECT
								t1.event_id,
								t1.status as paymentstatus,
								t2.* ,
								t1.*,
								t3.*,
								t4.event_name
							FROM
							tbl_racer_registration t1
							INNER JOIN tbl_reg_event_cart_session t2
								ON t1.id = t2.registration_id
							INNER JOIN tbl_products t3
								ON t2.product_id = t3.id
							INNER JOIN tbl_organizer_event t4
								ON t1.event_id = t4.id
							where t1.registered_racer_id = $user->id and (t1.action_type = 'register' or t1.action_type = 'buy only')";
			$getuserstatus = DB::select($sql);

			$base 		= $this->this_url;
			$html 		= '';
			$count 		= 0;
			$html2 		= '';
			$thumbnail 	= '';

			$product_firstname 			= '';
			$product_shipping_address 	= '';
			$product_phone 				= '';
			$product_shipping_name 		= '';

			$group_all_event_id = array();

			$all_products = '';
			$all_products_wrapper = '';

			$event_id = 0;

			foreach($getuserstatus as $values)
			{
				$group_all_event_id[$values->registration_id][] = $values ;
			}



			if(!empty($group_all_event_id)){
				$counterss = 0;
				foreach($group_all_event_id as $key => $val)
				{

					// GET ALL THE CATEGORY CURRENCY
					$event_id = 0;




					$all_products = '';
					$totalLine = 0;
					$shop_currency = '';

					foreach($val as $vv)
					{


						$tbl_category_events =	DB::table('tbl_category_events')
								->join('tbl_country', 'tbl_category_events.currency', '=', 'tbl_country.name')
								->where(['tbl_category_events.event_id' => $vv->event_id ])
								->get();

						if(!$tbl_category_events->isEmpty())
						{
							foreach($tbl_category_events as $v)
							{
								$shop_currency = $v->currency;
							}
						}



							$all_products .='

								<tr>
									<td>
									<img style="width:50px" src="/uploads/'.$vv->product_image.'">
									'.$vv->product_name.'</td>
									<td>'.$shop_currency.'&nbsp;'.$vv->_line_unit_price.'</td>
									<td> '.$vv->_line_product_qty.'</td>
									<td> '.$shop_currency. '&nbsp;'.($vv->_line_unit_price * $vv->_line_product_qty).'</td>
								</tr>

						';
						$totalLine += $vv->_line_unit_price * $vv->_line_product_qty;
						//$all_products .='<div style="padding:10px;"><img style="width:50px" src="/uploads/'.$vv->product_image.'"> X '.$vv->_line_product_qty.'&nbsp;'.  $vv->product_name. '<div>'.$vv->currency.$vv->_line_unit_price.'</div></div>';
					}

					$all_products = $all_products.'<tr style="background:#eee;"><td colspan="2"> <strong>Event Name:</strong> '.$vv->event_name.' <button style="display:none;" class="btn btn-primary btn-danger">Delete</button> </td><td colspan="2" style="text-align:right;"><button class="btn btn-primary">Total&nbsp;&nbsp;<strong>'.$shop_currency.'&nbsp;'. $totalLine.'</strong></button></td></tr>';

					if($counterss == 0){
						$countheader = '<h6 style="padding-top:16px;">Order Details</h6>';
					}else {
						$countheader = '';
					}
					$counterss++;
					$all_products_wrapper .= '<div class="wrapper_all_order" >
												'.$countheader.'
												<div style="margin: 7px;background: #fff;padding: 14px;">
												<div class="wrapper_item_shop_list" style="">
													<div class="row">
														<div class="item col-md-4" style="padding-right:4px;">
														<strong>Name:</strong>&nbsp;'.$user_firstname.'</div>

														<div class="item col-md-4" style="padding-right:4px;">
														<strong>Address:</strong>&nbsp;'.$vv->shipping_address.'</div>

														<div class="item col-md-4" style="padding-right:4px;">
														<strong>Contact #:</strong>&nbsp;'.Auth::user()->contact.'</div>
													</div>

													<div class="row">
														<div class="item col-md-4" style="padding-right:4px;">
															<strong>Tracking #:</strong>&nbsp;'.$vv->transaction_id.'</>
														</div>


														<div class="item col-md-4" style="padding-right:4px;">
														<strong>Referrence #:</strong>&nbsp;'.$vv->refno.'</div>
													</div>
												</div>
												<table class="table">
												<thead>
													<tr>
														<th>
															Product Name
														</th>
														<th>
															Price
														</th>
														<th>
															Qty
														</th>
														<th style="width:17%">
															Product Total
														</th>
													</tr>
												</thead>
												<tbody>
												'.$all_products.

											 '</tbody></table></div></div>';
				}
			}

				/*$button = '';

				if($count==0){
					$button ='<div class="common_button view_button_details" style="float: right;position: absolute;right: 0px;">Details</div>';
				}

				$html .='<div class="col-md-12" style="display:block; padding-top:20px">
							<div class="d" style="display: flex;position: relative;">
								<img src="'. $this->this_url .'/uploads/'.$values->product_image.'" width="70px">
								<ul class="order_detailsList" style="display: block;">
									<li>X '.$values->qty.' '.$values->product_name.'</li>
									<li class="order_price_profile">'.$values->price.'</li>
									</ul>
								'.$button .'
							</div>
						</div>';

				$thumbnail .='<div class="" style="margin-top:20px;display:flex">
								<img style="width:40%; height:200px;" src="'.$base.'/uploads/'.$values->product_image.'">
								<ul class="order_detailsList" style="display: block;">
								<li>X '.$values->qty.' '. $values->product_name.'</li>
								<li class="order_price_profile">'.$values->price.'</li>
								</ul>
							</div>';

				$product_firstname = $values->firstname;
				$product_shipping_address = $values->shipping_address;
				$product_phone = $values->phone;
				$product_shipping_name = $values->shipping_name;

			$count++;*/

		//s}

		/*$html2 .= '<div class="profile_order_info1" style="display:none;margin-top:32px">
					<div class="row">
						<div class="col">
							'.$thumbnail.'
						</div>
						<div class="col">
							<h4>Order Details</h4>
							<ul class="order_details_info_box" style="display: block; padding-left:0px">
								<li>Name: <strong>'.$product_firstname.'</strong></li>
								<li>Delivery Address: <strong>'.$product_shipping_address.'</strong></li>
								<li>Contact Number: <strong>'.$product_phone.'</strong></li>
								<li>Tracking Number: <strong>&nbsp;</strong></li>
								<li>Shipping Carrier: <strong>'.$product_shipping_name.'</strong></li>
							</ul>
						</div>
					</div>';*/

		$html = $html . $html2;
		return response()->json( array('html'=>$all_products_wrapper, 'status'=>'success', 'msg'=> $this->message_registration_approved ) );
	}

	/*  During onload call this function for the registration status
	 *  Pending payment, paid , submitted , registered
	 *  RegisterStatus
	 */
	public function checkracer_pending()
	{

				$event_id = 0;
				$user 	  = Auth::user();
				$user_id  = $user->id;


				// Filter if nahuman ba nya ang process
				$sql = "SELECT  T2.event_name  as e_event_name ,
								T2.country as e_country,
								T2.city_town  as e_town ,
								T2.event_date_race as e_event_date_race  ,
								T2.event_reg_close_time as e_reg_close_time,
								T2.event_image_name as e_event_image_name,
								T2.is_shop_enable,
								T4.*
						from tbl_racer_registration  T4
						inner join tbl_organizer_event T2
						ON T4.event_id = T2.id
						where T4.registered_racer_id = $user->id
						and T4.registration_submit_status = 1
						and T4.action_type = 'register'
						order by T4.id desc";

				$getuserstatus = DB::select($sql);

				$registration_array = array();
				$product_list 	    = array();
				$all_query 			= array();

				if(count($getuserstatus)>0)
				{
					foreach($getuserstatus as $v)
					{
						$registration_array['event'][] = $v;
						$reg_id   = $v->id;
						$event_id = $v->event_id;
					}
				}

		$base  	  = url('/');
		$all_html = '';

		if( count($registration_array) > 0 )
		{
			$image   = '';
			$html    = '';
			$payment_method = '';
			foreach($registration_array['event'] as $key=>$values)
			{
					// check the other buy
					$checkifnaapending =DB::table('tbl_racer_registration')
										->where('action_type','buy only')
										->where('status',0)
										->where('payment_method_name', 'Bank Deposit' )
										->orwhere('payment_method_name', 'Raceyaya Payment Portal' )
										->where('event_id',$values->event_id)
										->where('registered_racer_id',$user->id)->get();

					$yes_naa_pending = '';
					$payment_method = '';

					// PARA SA IF NAA BA OTHER BUY ITEMS / PERO HUMANA NA SYA NAG REGISTER
					if( count($checkifnaapending)>0)
					{
						$getstatus = 0;

						foreach($checkifnaapending as $stagus)
						{
							$getstatus = $stagus->status;
							$payment_method = $stagus->payment_method_name;
						}

						$yes_naa_pending = '<button x-status="'.$getstatus.'" x-event="'.$values->event_id.'" style="width: 100%;display:  inline-block;background: #64C0FF;text-align: center;border: 0px;margin-top: 7px;padding: 2px;font-size: 12px;padding-top: 10px;padding-bottom: 10px;color: #fff;" class="shopped_items">Shopped Items</button>';
					}


					//  CHECK IF EMPTY BA ANG SHOP


					$payment       = '';
					$payment_first = '';

					if($values->action_type == 'register')
					{
						$empty_shop_ = 0;
						$check_empty_shop = DB::table('tbl_products')->where('event_id',$values->event_id)->get();

						if( count($check_empty_shop) == 0){
							$empty_shop_ = 1;
						}
						if($values->is_shop_enable == 0)
						{
							$shop_disable = 'Shop Disabled';
						}else if($empty_shop_ == 1){
							$shop_disable = 'Shop Empty';
						}else {
							$shop_disable = 'Go to Shop';
						}

						// pending
						if($values->status == 0)
						{
							if($values->payment_method_name == 'Raceyaya Payment Portal'){
								$id_ = $values->transaction_id;
							 }else{
								$id_ = $values->id;
							 }
							$payment_first = '<a xpayment="'.$values->payment_method_name.'" style="width:100%;background:rgb(255, 67, 66) none repeat scroll 0% 0%; display:inline-block;text-align:center;" href="javascript:void(0)"><span xev-id="'.$values->event_id.'" x-regd-id="'.$id_.'" class="pending_payment_btn" style="background:none !important;">Pending Payment</span></a><i style="text-align:center;font-size: 12px;line-height: 16px;height: 36px;display: flex;color: #ef3be6;margin-top: 4px;text-align: left;">Needs to complete requirement</i>';
							if($values->is_shop_enable == 0){
								$payment = $payment_first . '<a xshop-enable="'.$values->is_shop_enable.'" style="width: 100%;display:  inline-block;background: grey;text-align: center;" href="#"><span xev-id="'.$values->event_id.'" x-regd-id="'.$values->id.'" class="" style="background:none !important;padding: 9px;display: inline-block;font-size: 12px;color: #fff;cursor: pointer;">'.$shop_disable.'</span></a>';
							}else if($empty_shop_ == 1){
								$payment = $payment_first . '<a xshop-enable="'.$values->is_shop_enable.'" style="width: 100%;display:  inline-block;background: grey;text-align: center;" href="#"><span xev-id="'.$values->event_id.'" x-regd-id="'.$values->id.'" class="" style="background:none !important;padding: 9px;display: inline-block;font-size: 12px;color: #fff;cursor: pointer;">'.$shop_disable.'</span></a>';
							} else {
								$payment = $payment_first . '<a xshop-enable="'.$values->is_shop_enable.'" style="width: 100%;display:  inline-block;background: #64C0FF;text-align: center;" href="event-shop/'.$values->event_id.'/'.$values->id.'"><span xev-id="'.$event_id.'" x-regd-id="'.$values->id.'" class="" style="background:none !important;padding: 9px;display: inline-block;font-size: 12px;color: #fff;cursor: pointer;">'.$shop_disable.'</span></a>';
							}
						// paid
						}else if($values->status == 1)
						{

							$payment_first  = '<span  xev-id="'.$event_id.'" x-regd-id="'.$values->id.'" class="paid_registration_details"  style="background:#7fd8b3  !important;padding-left: 12px;padding-right: 12px;padding-top: 9px;padding-bottom: 9px;color: #fff;font-size: 12px;width: 100%;display: inline-block;text-align: center;">Paid</span>';
							if($values->is_shop_enable == 0){
								$payment =  $payment_first . '<a xshop-enable="'.$values->is_shop_enable.'"  style="margin-top:5px;width: 100%;display:  inline-block;background:grey;text-align: center;" href="#"><span  x-regd-id="'.$values->id.'" class="" style="background:none !important;padding: 9px;display: inline-block;font-size: 12px;color: #fff;cursor: pointer;">Shop Disable</span></a>';
						   }else if($empty_shop_ == 1){
								$payment =  $payment_first . '<a xshop-enable="'.$values->is_shop_enable.'"  style="margin-top:5px;width: 100%;display:  inline-block;background:grey;text-align: center;" href="#"><span  x-regd-id="'.$values->id.'" class="" style="background:none !important;padding: 9px;display: inline-block;font-size: 12px;color: #fff;cursor: pointer;">Shop Empty</span></a>';
						   }else {
								$payment =  $payment_first . '<a xshop-enable="'.$values->is_shop_enable.'"  style="margin-top:5px;width: 100%;display:  inline-block;background: #64C0FF;text-align: center;" href="event-shop/'.$values->event_id.'/'.$values->id.'"><span  x-regd-id="'.$values->id.'" class="" style="background:none !important;padding: 9px;display: inline-block;font-size: 12px;color: #fff;cursor: pointer;">'.$shop_disable.'</span></a>';

							}
						// registered
						}else if($values->status == 2)
						{
							$payment_first  = '<span  x-regd-id="'.$values->id.'" class="registered_registration_details"  style="background:#7fd8b3  !important;padding-left: 12px;padding-right: 12px;padding-top: 9px;padding-bottom: 9px;color: #fff;font-size: 12px;width: 100%;display: inline-block;text-align: center;">Registered</span>';
							if($values->is_shop_enable == 0){
								$payment =  $payment_first . '<a style="margin-top:5px;width: 100%;display:  inline-block;background: grey;text-align: center;" href="#"><span xev-id="'.$values->event_id.'"  x-regd-id="'.$values->id.'" class="" style="background:none !important;padding: 9px;display: inline-block;font-size: 12px;color: #fff;cursor: pointer;">'.$shop_disable.'</span></a>';
							}else{
								$payment =  $payment_first . '<a style="margin-top:5px;width: 100%;display:  inline-block;background: #64C0FF;text-align: center;" href="event-shop/'.$values->event_id.'/'.$values->id.'"><span xev-id="'.$event_id.'"  x-regd-id="'.$values->id.'" class="" style="background:none !important;padding: 9px;display: inline-block;font-size: 12px;color: #fff;cursor: pointer;">'.$shop_disable.'</span></a>';
							}
						} else if($values->status == 3){
							$payment_first  = '<span x-regd-id="'.$values->id.'" style="text-align:center;background:#eee !important;padding-left: 12px;padding-right: 12px;padding-top: 9px;padding-bottom: 9px;color: #000;font-size: 12px;width: 100%;display: inline-block;text-align: center;" class="submitted_registration_details" style="">Submitted</span>';
							if($values->is_shop_enable == 0){
								$payment = $payment_first . '<a style="margin-top:5px;width: 100%;display:  inline-block;background: grey;text-align: center;" href="#"><span xev-id="'.$values->event_id.'"  x-regd-id="'.$values->id.'" class="" style="background:none !important;padding: 9px;display: inline-block;font-size: 12px;color: #fff;cursor: pointer;">'.$shop_disable.'</span></a>';

							}else{
								$payment = $payment_first . '<a style="margin-top:5px;width: 100%;display:  inline-block;background: #64C0FF;text-align: center;" href="event-shop/'.$values->event_id.'/'.$values->id.'"><span xev-id="'.$event_id.'"  x-regd-id="'.$values->id.'" class="" style="background:none !important;padding: 9px;display: inline-block;font-size: 12px;color: #fff;cursor: pointer;">'.$shop_disable.'</span></a>';

							}
						} else if($values->status == 5){

							$payment_first  = '<span x-regd-id="'.$values->id.'" style="text-align:center;background:#eee !important;padding-left: 12px;padding-right: 12px;padding-top: 9px;padding-bottom: 9px;color: #000;font-size: 12px;width: 100%;display: inline-block;text-align: center;" class="pending_payment_btn" style="">Cancelled</span>';
							if($values->is_shop_enable == 0){
								$payment = $payment_first . '<a style="margin-top:5px;width: 100%;display:  inline-block;background: grey;text-align: center;" href="#"><span xev-id="'.$values->event_id.'"  x-regd-id="'.$values->id.'" class="" style="background:none !important;padding: 9px;display: inline-block;font-size: 12px;color: #fff;cursor: pointer;">'.$shop_disable.'</span></a>';

							}else{
								$payment = $payment_first . '<a style="margin-top:5px;width: 100%;display:  inline-block;background: #64C0FF;text-align: center;" href="event-shop/'.$values->event_id.'/'.$values->id.'"><span xev-id="'.$event_id.'"  x-regd-id="'.$values->id.'" class="" style="background:none !important;padding: 9px;display: inline-block;font-size: 12px;color: #fff;cursor: pointer;">'.$shop_disable.'</span></a>';

							}
						}

					$html .= '<div class="row" style="">
								<div class="col-md-2">
								<img style="height:150px; width:150px;padding-left:0px;" src="'. $this->this_url .'/uploads/'.$values->e_event_image_name.'"/>
								</div>
								<div class="col-md-8">
										<h5>'.$values->e_event_name.'</h5>
										<ul class="registered_race_profile_list" style="width: 100%;display: flex;flex-wrap: wrap;">
											<li>Time:<strong>'.$values->e_reg_close_time.'</strong></li>
											<li>Date: <strong>'.$values->e_event_date_race.'</strong></li>
											<li>Location: <strong>'.$values->e_town.' '.$values->e_town.'</strong></li>
											<li>Ref#: <strong>'.$values->refno.'</strong></li>
										</ul>
								</div>
								<div class="col-md-2">
									'.$payment.'

									<div class="hashoppeditems">
									'.$yes_naa_pending.'
									</div>

								</div>
							</div>';
					}
			}

			$all_html .= $html;
			return response()->json( array('html'=>$all_html, 'status'=>'success', 'msg'=> $this->message_registration_approved ) );

		}else{
			return response()->json( array('html'=> 'No registered races',  'status'=>'failed', 'msg'=> $this->message_registration_pending ) );
		}
	}

	/**
	 *  Get Participants Full Payments
	 */
	public function getparticipantsfulldetails($f)
	{
		$registration_user_id = $f;

		$user_details = DB::table('tbl_racer_registration')->where('id',$registration_user_id)->get();

		$html 			 = '';
		$registration_id = 0;
		$upload 		 = '/uploads/receipt/';
		$receipt_upload  = '';
		$event_id = 0;

		$document_remarks = '';
		$document_status  = 0;
        $receipt_status=0;
		$userid = Auth::user()->id;

		if(!$user_details->isEmpty())
		{
			foreach($user_details as $v)
			{

				$receipt_upload  = $v->upload_receipt;
				$registration_id = $v->id;

				$reg_id_other_racer_user_id = $v->id;

				$event_id 		 = $v->event_id;
				$REGISTRATION_ID_RACER 		 = $v->registered_racer_id;
				$document_remarks = $v->document_remarks;
				$document_status  = $v->document_status;
                $receipt_status =$v->receipt_status;
				$option = '';

				// CHECK IF IT HAS OTHER PENDING PAYMENTS, // CHECK IF IT HAS OTHER PENDING PAYMENTS
				$sql = "SELECT
                t1.event_id,
                t1.status as paymentstatus,
                t2.* ,
                t1.*,
                t3.*,
                t4.event_name
                FROM
                tbl_racer_registration t1
                INNER JOIN tbl_reg_event_cart_session t2
                    ON t1.id = t2.registration_id
                INNER JOIN tbl_products t3
                    ON t2.product_id = t3.id
                INNER JOIN tbl_organizer_event t4
                    ON t1.event_id = t4.id
                where t1.registered_racer_id = $REGISTRATION_ID_RACER and
                t1.action_type = 'buy only' and
				( t1.status = 0 or t1.status = 3) and
                t1.payment_method_name = 'Bank Deposit' and
                t1.event_id = $event_id";

            $getuserstatus = DB::select($sql);
            $group_all_event_id = array();

            //echo 'This is a test';
			$html = '';
			$html_pending_elements = 'No Pending Payments';
			if( count($getuserstatus)> 0){

            foreach($getuserstatus as $values)
			{
				$group_all_event_id[$values->registration_id][] = $values ;
			}


			$all_products_wrapper = '';
			$markbutton = '';
			$stagus = 0;
			$submitted_fields = '';

			if(!empty($group_all_event_id))
			{
                $counterss = 0;

                $all_total = 0;
				foreach($group_all_event_id as $key => $val)
				{

					// GET ALL THE CATEGORY CURRENCY
					$event_id = 0;

					$all_products = '';
					$totalLine = 0;
					$shop_currency = '';
                    $stagus = 0;
                    $submitted_fields = '';

					foreach($val as $CHECK)
					{

                        $stagus = $CHECK->paymentstatus;

						if($CHECK->paymentstatus==3){
							$markbutton = '<button x-reg-id="'.$REGISTRATION_ID_RACER.'" x-event-id="'.$CHECK->event_id.'" style="background:red" class="btn btn-secondary organizer_completed_and_verified">Mark as Complete and Verified</button>';
						}else if($CHECK->paymentstatus==1){
							$markbutton = '<button x-reg-id="'.$REGISTRATION_ID_RACER.'" x-event-id="'.$CHECK->event_id.'" style="width:100%;background:#57aa57" class="btn btn-secondary organizer_completed_and_verified">Payment has been completed and verified</button>';
						}

                        if($stagus == 3){
                            $submitted_fields = ' <div class="col-md-12 bank_deposit_registration_status">

                            <div class="row shipping_option_wrapper mt-5 mb-4">
                              <div class="mb-3 col-md-5" style="display: block;">
                                  <label style="width:100%;text-align:left;background:#eee;font-weight:bold;" for="">Bank Name</label>
                                  <p style="padding:12px;">'.$CHECK->submit_bank_name.'</p>
                              </div>
                              <div class="mb-3 col-md-5" style="display: block;">
                                  <label  style="width:100%;text-align:left;background:#eee;font-weight:bold;"for="">Account Name</label>
                                  <p style="padding:12px;">'.$CHECK->submit_deposit_name.'</p>
                              </div>
                              <div class="mb-3 col-md-5" style="display: block;">
                                  <label style="width:100%;text-align:left;background:#eee;font-weight:bold;" for="">Reference Number</label>
                                  <p style="padding:12px;">'.$CHECK->submit_reference_number.'</p>
                              </div>
                              <div class="mb-3 col-md-5" style="display: block;">
                                <label  style="width:100%;text-align:left;background:#eee;font-weight:bold;" for="">Amount Deposited</label>
                                <p style="padding:12px;">'.$CHECK->submit_amount_deposited.'</p>
                              </div>
                          </div>
                        </div>';
                        }else{
							$submitted_fields = ' <div class="col-md-12 bank_deposit_registration_status">

                            <div class="row shipping_option_wrapper mt-5 mb-4">
                              <div class="mb-3 col-md-5" style="display: block;">
                                  <label style="width:100%;text-align:left;background:#eee;font-weight:bold;" for="">Bank Name</label>
                                  <p style="padding:12px;">'.$CHECK->submit_bank_name.'</p>
                              </div>
                              <div class="mb-3 col-md-5" style="display: block;">
                                  <label  style="width:100%;text-align:left;background:#eee;font-weight:bold;"for="">Account Name</label>
                                  <p style="padding:12px;">'.$CHECK->submit_deposit_name.'</p>
                              </div>
                              <div class="mb-3 col-md-5" style="display: block;">
                                  <label style="width:100%;text-align:left;background:#eee;font-weight:bold;" for="">Reference Number</label>
                                  <p style="padding:12px;">'.$CHECK->submit_reference_number.'</p>
                              </div>
                              <div class="mb-3 col-md-5" style="display: block;">
                                <label  style="width:100%;text-align:left;background:#eee;font-weight:bold;" for="">Amount Deposited</label>
                                <p style="padding:12px;">'.$CHECK->submit_amount_deposited.'</p>
                              </div>
                          </div>
                        </div>';
						}





						$tbl_category_events =	DB::table('tbl_category_events')
								->join('tbl_country', 'tbl_category_events.currency', '=', 'tbl_country.name')
								->where(['tbl_category_events.event_id' => $CHECK->event_id ])
								->get();

						if(!$tbl_category_events->isEmpty())
						{
							foreach($tbl_category_events as $CUR)
							{
								$shop_currency = $CUR->currency;
							}
						}



							$all_products .='
								<tr>
									<td>
									<img style="width:50px" src="/uploads/'.$CHECK->product_image.'">
									'.$CHECK->product_name.'</td>
									<td>'.$shop_currency.'&nbsp;'.number_format($CHECK->_line_unit_price,2).'</td>
									<td> '.$CHECK->_line_product_qty.'</td>
									<td> '.$shop_currency. '&nbsp;'.number_format($CHECK->_line_unit_price * $CHECK->_line_product_qty,2).'</td>
								</tr>

						';
						$totalLine += $CHECK->_line_unit_price * $CHECK->_line_product_qty;

                        //$all_products .='<div style="padding:10px;"><img style="width:50px" src="/uploads/'.$vv->product_image.'"> X '.$vv->_line_product_qty.'&nbsp;'.  $vv->product_name. '<div>'.$vv->currency.$vv->_line_unit_price.'</div></div>';
					}
                    $all_total += $totalLine ;
					$all_products = $all_products.'<tr style="background:#eee;"><td colspan="2"> <strong></strong> '.''.' <button style="display:none;" class="btn btn-primary btn-danger">Delete</button> </td><td colspan="2" style="text-align:right;"><button type="submit" style="border:0px;" class="">Sub Total&nbsp;&nbsp;<strong>'.$shop_currency.'&nbsp;'. number_format($totalLine,2).'</strong></button></td></tr>';

					if($counterss == 0){
						$countheader = '<h6 class="heading_title" style="padding-top:0px;">Order Details</h6>';
					}else {
						$countheader = '';
                    }

					$counterss++;
					$all_products_wrapper .= '<div class="wrapper_all_order" >
												'.$countheader.'
												<div style="margin: 7px;background: #fff;padding: 14px;">
												<div>Transaction #:</div>
												<table class="table">
												<thead>
													<tr>
														<th>
															Item Name
														</th>
														<th>
															Price
														</th>
														<th>
															Qty
														</th>
														<th style="width:17%">
															Product Total
														</th>
													</tr>
												</thead>
												<tbody>
												'.$all_products.

											 '</tbody></table></div></div>';
                }


            }

            if($stagus == 3){
                $payment_method = $submitted_fields;
            }else{

            $payment_method = $submitted_fields;
        }


				$html_pending_elements = $payment_method.$markbutton.$all_products_wrapper.'<table class="table"><tr><td><span style="font-size:15pt;font-weight:bold;">Grand Total: '.$shop_currency.'&nbsp;'.number_format($all_total,2).'</span></td></tr></table><div class="row"><div class="col-md-4"> <div class="inner_wrapper_payment_box"></div><br/></div>';
	}
			// PENDING EVENTS



				$status = '<select x-id="'.$registration_user_id.'" style="width:30%" class="status_full_details_select browser-default custom-select" name="" id="status_status">
							<option value="" selected="selected" disabled></option>';

							// PENDING 0
							if($v->status == 0){
								$option .='<option  x-id="'.$registration_user_id.'" selected="selected" value="0">Pending</option>';
							}else{
								$option .='<option  x-id="'.$registration_user_id.'" value="0">Pending</option>';
							}

							// PAID 1
							if($v->status == 1){
								$option .='<option   x-id="'.$registration_user_id.'" selected="selected" value="1">Paid</option>';
							}else{
								$option .='<option   x-id="'.$registration_user_id.'" value="1">Paid</option>';
							}

							// REGISTERED 2
							if($v->status == 2){
								$option .='<option   x-id="'.$registration_user_id.'" selected="selected" value="2">Registered</option>';
							}else{
								$option .='<option   x-id="'.$registration_user_id.'" value="2">Registered</option>';
							}

							// Submitted 3
							if($v->status == 3){
								$option .='<option   x-id="'.$registration_user_id.'" selected="selected" value="3">Submitted</option>';
							}else{
								$option .='<option   x-id="'.$registration_user_id.'" value="3">Submitted</option>';
							}

				$html_option = $status.$option.'</select>';

				$payment_method = $v->payment_method_name == 'Raceyaya Payment Portal' ? 'Dragonpay': $v->payment_method_name;

				$payment_date    = ( $v->date_pament     === '')  ?  ''  :  date('F d, Y', strtotime($v->date_pament));
				$date_registered = ( $v->date_registered === '')  ?  ''  :  date('F d, Y', strtotime($v->date_registered));

				if ($v->date_pament=='' && $v->date_registered==''){
						$html = '<div  class="inner_target_full_details" id="main_info">
							<div class="form-group"><label for="">Status:</label>
								'.$html_option.'
							</div>
							<div class="form-group">
								<label for="email">Payment Date:</label>
								Not yet paid
							</div>
							<div class="form-group">
								<label for="email">Registered Date:</label>
								Not yet Registered
							</div>
							<div class="form-group">
								<label for="email">Payment Method:</label>
								'.$payment_method.'
							</div>';
					}else if($v->date_pament!='' && $v->date_registered=='') {
						$html = '<div  class="inner_target_full_details" id="main_info">
						<div class="form-group"><label for="">Status:</label>
							'.$html_option.'
						</div>
						<div class="form-group">
							<label for="email">Payment Date:</label>
							'.date('F d, Y', strtotime($v->date_pament)).'
						</div>
						<div class="form-group">
							<label for="email">Registered Date:</label>
							not yet registered
						</div>
						<div class="form-group">
							<label for="email">Payment Method:</label>
							'.$payment_method.'
						</div>';
					}else{
						$html = '<div  class="inner_target_full_details" id="main_info">
						<div class="form-group"><label for="">Status:</label>
							'.$html_option.'
						</div>
						<div class="form-group">
							<label for="email">Payment Date:</label>
							'.date('F d, Y', strtotime($v->date_pament)).'
						</div>
						<div class="form-group">
							<label for="email">Registered Date:</label>
							'.date('F d, Y', strtotime($v->date_registered)).'
						</div>
						<div class="form-group">
							<label for="email">Payment Method:</label>
							'.$payment_method.'
						</div>';
					}
				if($payment_method == 'Dragonpay'){
					$html .= '<div class="form-group">
								<label for="email">Transaction ID:</label>
								'.$v->dragonpay_tnxid.'
							</div>';
				}

				$html .= '<div class="form-group">
								<label for="email">Payment Reference No.:</label>
								'.$v->refno.'
							</div>
							<div class="form-group">
								<label for="email">First name:</label>
								'.$v->firstname.'
							</div>
							<div class="form-group">
								<label for="pwd">Last name:</label>
								'.$v->lastname.'
							</div>
							<div class="form-group">
								<label for="pwd">Address:</label>
								'.$v->address.'
							</div>
							<div class="form-group">
								<label for="pwd">Phone:</label>
								'.$v->phone.'
							</div>
							<div class="form-group">
								<label for="pwd">Age:</label>
								'.$v->age.'
							</div>
							<div class="form-group">
								<label for="pwd">Gender:</label>
								'.$v->gender.'
							</div>
							<div class="form-group">
								<label for="pwd">Email Address:</label>
								'.$v->email.'
							</div>
							<div class="form-group">
								<label for="pwd">Category:</label>
								'.$v->category_id.'
							</div>
							<div class="form-group">
								<label for="pwd">Nationality:</label>
								'.$v->nationality.'
							</div>
							<div class="form-group">
								<label for="pwd">Country:</label>
								'.$v->country.'
							</div>
							<div class="form-group">
								<label for="pwd">Zip:</label>
								'.$v->zip.'
							</div>
							<div class="form-group">
								<label for="pwd">City:</label>
								'.$v->city.'
							</div>
							<div class="form-group">
								<label for="pwd">State:</label>
								'.$v->state.'
							</div>
						</div>

					    <div style="display:none;"  class="inner_target_full_details" id="main_shipping">
							<div class="form-group">
								<label for="pwd">Address:</label>
								'. $v->shipping_address .'
							</div>
							<div class="form-group">
								<label for="pwd">Country:</label>
								'.$v->shipping_country  .'
							</div>
							<div class="form-group">
								<label for="pwd">City:</label>
								'.$v->shipping_city  .'
							</div>

							<div class="form-group">
								<label for="pwd">Zip:</label>
								'.$v->shipping_zip  .'
							</div>
							<div class="form-group">
								<label for="pwd">Fee:</label>
								'.$v->shipping_fee_amount  .'
							</div>

						</div>

						';
			}


				$ALLQUESTION_EVENTS = DB::table('tbl_additional_question')->where('tbl_additional_question.event_id',$event_id)->get();
                $question_html = '';

                if( !$ALLQUESTION_EVENTS->isEmpty() )
                {

                        /** from registration table */


						if($document_status == 3){
							$document_status = 'color:blue;';
							$document_status_disable = 'color:grey;';
						}else{
							$document_status = 'color:grey;';
							$document_status_disable = 'color:blue;';
						}

    //                 $question_html .='
    //                                         <div style="display:block;" class="oregistrant_target_'.$registration_user_id.'">
				// 									<div class="mb-5">
				// 										<label class="your_remark" style="background:none;width:100%;text-align:left;text-decoration:none; padding-bottom:0px;cursor:pointer;">Add remark (Display in racer registration status)</label>
				// 										<p class="remark_textarea" style="padding:12px;display:block;padding-top:0px;border-bottom:1px solid #ddd;">
				// 											<textarea class="you_remark form-control">'.$document_remarks.'</textarea>
				// 											<i style="padding-top:4px;display: inline-block;font-size: 13px;"></i>
				// 											<br/>
				// 											<button xreg-id="'.$registration_user_id.'" style="font-size:12px; padding:10px;" class="btn btn-primary add_remark_now">Save remark now</button>
				// 										</p>
    //                                         		</div>
				// 									<div class="mb-12">

				// 									<p>
				// 										<span xreg-id="'.$registration_user_id.'" xdata="approve" style="'.$document_status.' display: inline-block;padding-top: 8px;;cursor:pointer;" class="trigger_approve_registration">Approve</span>&nbsp;|&nbsp;<span  xreg-id="'.$registration_user_id.'" style="'.$document_status_disable.' display: inline-block;padding-top: 8px;cursor:pointer;" xdata="disapprove" class="trigger_approve_registration">Disapprove</span>
				// 									</p>
				// 									<div><strong>User Additional information</strong></div>
				// 									</div>';

                        $counttt = 1;

                        /**
                         *  ALLQUESTION_EVENTS
                         */
                        foreach($ALLQUESTION_EVENTS as $val)
                        {

                            /** The question id  */
                            if( $val->question_type =='question_upload' )
                            {

                                /** Upload question ANSWER */

                                $question_answer = DB::table('tbl_registration_question_answer')
                                                    ->where('tbl_registration_question_answer.additional_question_id',$val->id)
                                                    ->where('tbl_registration_question_answer.question_type','upload')
                                                    ->where('tbl_registration_question_answer.registration_id',$reg_id_other_racer_user_id)
                                                    ->get();



                                if(!$question_answer->isEmpty())
                                {
									$question_html .='
									<div style="display:block;" class="oregistrant_target_'.$registration_user_id.'">
											<div class="mb-5">
												<label class="your_remark" style="background:none;width:100%;text-align:left;text-decoration:none; padding-bottom:0px;cursor:pointer;">Add remark (Display in racer registration status)</label>
												<p class="remark_textarea" style="padding:12px;display:block;padding-top:0px;border-bottom:1px solid #ddd;">
													<textarea class="you_remark form-control">'.$document_remarks.'</textarea>
													<i style="padding-top:4px;display: inline-block;font-size: 13px;"></i>
													<br/>
													<button xreg-id="'.$registration_user_id.'" style="font-size:12px; padding:10px;" class="btn btn-primary add_remark_now">Save remark now</button>
												</p>
											</div>
											<div class="mb-12">

											<p>
												<span xreg-id="'.$registration_user_id.'" xdata="approve" style="'.$document_status.' display: inline-block;padding-top: 8px;;cursor:pointer;" class="trigger_approve_registration">Approve</span>&nbsp;|&nbsp;<span  xreg-id="'.$registration_user_id.'" style="'.$document_status_disable.' display: inline-block;padding-top: 8px;cursor:pointer;" xdata="disapprove" class="trigger_approve_registration">Disapprove</span>
											</p>
											<div><strong>User Additional information</strong></div>
											</div>';

                                    foreach($question_answer as $quest)
                                    {
                                        $question_html .='<div class="mb-5"><label style="width:100%;text-align:left">'.$counttt.'. '.$quest->the_question.'</label>
                                                          <img style="width:100%" src="'.url('/').'/'.$quest->question_answer.'">
                                                          </div>  ';
                                    }
                                }else{
                                    $question_html .='  <div class="mb-5"><label style="width:100%;text-align:left">'.$counttt.'. '.$val->question.'</label>
                                                            <p style="">
                                                               No uploaded document
                                                            </p>
                                                        </div>';
                                }

                            } elseif( $val->question_type =='question_textarea' )
                            {

                                $question_answer =  DB::table('tbl_registration_question_answer')
                                                    ->where('tbl_registration_question_answer.additional_question_id',$val->id)
                                                    ->where('tbl_registration_question_answer.question_type','question_textarea')
                                                    ->where('tbl_registration_question_answer.registration_id',$reg_id_other_racer_user_id)
                                                    ->get();

                                if(!$question_answer->isEmpty())
                                {
                                    foreach($question_answer as $quest)
                                    {
                                        $question_html .='<div class="mb-5"><label style="width:100%;text-align:left">'.$counttt.'. '.$quest->the_question.'</label>
                                                            <div class="the_answer">'.$quest->question_answer.'</div>

                                                          </div>';
                                    }
                                }else{
                                    /** PARA NI SA DILI UPLOAD */
                                    $question_html .='  <div class="mb-5"><label style="width:100%;text-align:left">'.$counttt.'.'.$val->question.'</label>
                                                            <p>No answer</p>
                                                        </div>';
                                }


                            } elseif( $val->question_type =='question_link' ){

                                $question_answer =  DB::table('tbl_registration_question_answer')
                                                    ->where('tbl_registration_question_answer.additional_question_id',$val->id)
                                                    ->where('tbl_registration_question_answer.question_type','question_link')
                                                    ->where('tbl_registration_question_answer.registration_id',$reg_id_other_racer_user_id)
                                                    ->get();

                                if(!$question_answer->isEmpty())
                                {
                                    foreach($question_answer as $quest)
                                    {
                                        $question_html .='  <div class="mb-5"><label style="width:100%;text-align:left">'.$counttt.'. '.$quest->the_question.'</label>
                                                            <div class="the_answer"><a target="blank" href="'.$quest->question_answer.'">'.$quest->question_answer.'</a></div>

                                                            </div>';
                                    }

                                }else{

                                    /** PARA NI SA DILI UPLOAD */
                                    $question_html .='  <div class="mb-5"><label style="width:100%;text-align:left">'.$counttt.'.'.$val->question.'</label>
                                                            <div>
                                                               No link
                                                            </div>
                                                        </div>';
                                }

                            }

                            $counttt++;
                        }

                        $question_html .= '</div>';
                }



			/*
			 *  FOR UPLOADED RECEIPT,FOR UPLOADED RECEIPT,
			 */
			if( $receipt_upload !='' )
			{
			    if($receipt_status == 3){
					$receipt_status = 'color:blue;';
					$document_status_disable = 'color:grey;';
				}else{
					$receipt_status = 'color:grey;';
					$document_status_disable = 'color:blue;';
				}

				$question_html .=   '<br/><div><strong>Bank Deposit Details:</strong></div'.
									'<div class="row">
										<div class="col-md-12">
											<label><strong>Bank Name:</strong></label>
											<span>'.$v->submit_bank_name.'</span>
										</div>
										<div class="col-md-12">
											<label><strong>Bank Account :</strong></label>
											<span>'.$v->submit_deposit_name.'</span>
										</div>
										<div class="col-md-12">
											<label><strong>Bank Account Number:</strong></label>
											<span>'.$v->submit_reference_number.'</span>
										</div>
										<div class="col-md-12">
											<label><strong>Bank Branch:</strong></label>
											<span>'.$v->submit_amount_deposited.'</span>
										</div>
									</div>';
				$question_html .=   '<br/><div><strong>Bank Deposit Receipts:</strong></div>
				<p><span xreg-id="'.$registration_user_id.'" xdata="approve" style="'.$receipt_status.' display: inline-block;padding-top: 8px;;cursor:pointer;" class="trigger_approve_receipt">Approve</span>&nbsp;|&nbsp;<span  xreg-id="'.$registration_user_id.'" style="'.$document_status_disable.' display: inline-block;padding-top: 8px;cursor:pointer;" xdata="disapprove" class="trigger_approve_receipt">Disapprove</span></p>
				<img style="width:100%" src="'. $upload.$receipt_upload .'"/>';
			}




			if( $question_html !='' ){
				$html .='<div style="display:none;" class="inner_target_full_details" id="main_question">'.$question_html.'</div>';
			}

			$html .='<div style="display:none;" class="inner_target_full_details" id="pending_payment_items">'.$html_pending_elements.'</div>';

			if($html !=''){
				$tab = '<div class="tab_full_details_wrapper">
							<span style="width:auto;" xtarget="#main_info"  class="col-md-4 tab_full_details_active tab_full_details">User info</span>
							<span style="width:auto;" xtarget="#main_question" class="col-md-4 tab_full_details">Document</span>
							<span  style="width:auto;" xtarget="#main_shipping" class="col-md-4 tab_full_details">Shipping</span>
							<span style="width:auto;"  xtarget="#pending_payment_items" class="col-md-4 tab_full_details">Pending Payment Items</span>
						</div>	';
			}
			return response()->json( array('html'=> $tab  . ''.$html,  'status'=>'failed' ) );
		}
		return response()->json( array('html'=> $html,  'status'=>'failed' ) );
	}


	/**
	 *  SSS Format
	 */
	private function sss_format(){
	}

	/**
	 *  Checkifhashop
	 */
	public function checkifhasShop(Request $f){
		//$session_id = $f->input('.session_id');
	}

	/**
	 *  Get organizer term and condition in front-racer-register
	 */
	public function getEventDetails(Request $request){
		$data["error"]=1;
		$result =DB::table('tbl_organizer_event')
				->where('id',$request->event_id)->first();
				if($result){
					$data["error"]=0;
					$data["data"]=$result;
				}
		echo json_encode($data);
		 die;
	}
}
