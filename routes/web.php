<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/**
 *    Author: Alexander Timbal
 *    Email: touchmealex@gmail.com
 */

Route::get('/', function () {
    return view('welcome');
});

Route::get('/clear-cache', function() {
    Artisan::call('view:clear');
    return "Cache is cleared";
});

Route::get('/clear-view', function() {
    Artisan::call('view:clear');
    return "View is cleared";
});

Auth::routes();

Route::get('/home', function () {
    return redirect('/');
});
Route::get('logout', function() {
	Auth::logout();
    Artisan::call('view:clear');
	return redirect('/login');
});

//Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/', 'HomeController@index')->name('home');

Route::group(['domain' => '{register}.raceyaya.comm'], function() {
	Route::get('/events', 'FrontRacerController@index')->name('front-racer');
});


Route::group(['domain' => '{register}.comm-app.local'], function() {	
	Route::get('/view-racer-event-details/{eventid}', 'CreateEventController@view_event_racer_details')->name('racer-view-details');
});

Route::post('/login/custom', 'LoginController@login')->name('login.custom');
Route::get('/create_account', 'CreateaccountController@index')->name('create_account');

Route::group(['middleware' => ['auth', 'admin']], function() 
{
		Route::get('/organizer', 'OrganizerController@index')->name('organizer');
		Route::get('/admin', 'AdminController@index')->name('admin');
		
		//Route::get('/resources', 'RacerController@index')->name('resources');
		Route::get('/racer-events', 'JordanController@racesevents')->name('racer_events');
		
		Route::post('/contact-us', 'ContactController@contactus')->name('contactme');
		Route::get('/organizer-create-event', 'CreateEventController@index')->name('eventcreate');
		Route::get('/organizer-create-event/{id}', 'CreateEventController@editView')->name('editcreate');
		Route::get('/organizer-event-remove/{id}', 'CreateEventController@remove')->name('removeevent');
					
		Route::get('/profile', 'ProfileController@index')->name('profile');
		// Added April 16, 2020
		Route::post('/profile', 'ProfileController@index')->name('profile');

		// ADMIN
		Route::get('/admin/pages', 'AdminPagesController@index')->name('admin_pages');
		Route::get('/admin/blog', 'AdminBlogController@index')->name('admin_blog');
		Route::get('/admin/category', 'AdminCategoryController@index')->name('admin_category');
		Route::get('/admin/users', 'AdminUsersController@index')->name('admin_users');
		Route::post('/admin/users', 'AdminUsersController@index')->name('admin_users');
		Route::get('/admin/settings', 'AdminController@settings')->name('admin.settings');
		Route::post('/admin/settings', 'AdminController@settings')->name('admin.settings');

		Route::get('/admin/myprofile', 'AdminMyProfileController@index')->name('admin_my_profile');

		Route::post('/admin-signup-list', 'AdminSignupController@index')->name('admin_signup_list');
		Route::get('/admin-signup-list', 'AdminSignupController@index')->name('admin_signup_list');
		Route::get('/admin-event-list', 'AdminEventListController@index')->name('admin_event_list');

		Route::post('/admin-event-list', 'AdminEventListController@index')->name('admin_event_list');

		Route::post('/admin-organizer-list', 'AdminOrganizerController@index')->name('admin_organizer_list');
		
		Route::get('/admin-organizer-list', 'AdminOrganizerController@index')->name('admin_organizer_list');
		Route::get('/admin-boost-list', 'AdminBoostController@index')->name('admin_boost_list');
		
		Route::post('/admin-boost-list', 'AdminBoostController@index')->name('admin_boost_list');
		Route::post('/boostsend', 'AdminBoostController@sendboost')->name('sendboost');
	
		Route::get('/admin-category', 'AdminCategoryController@index')->name('admin_category');	
		Route::post('/admin-category', 'AdminCategoryController@index')->name('admin_category');
		Route::get('/admin-category/new-cat', 'AdminCategoryController@new_cat')->name('new_cat');
		Route::post('/admin-category/new-cat', 'AdminCategoryController@new_cat')->name('new_cat');	
	// ADMIN	
	
	//Route::get('/racer-events', 'UserRacerController@jordantest')->name('racer_events');	
	Route::get('/racer-profile', 'UserRacerController@event_profile')->name('racer_profile');
	Route::get('/racer-jeff', 'JeffController@jefftest')->name('jefttest');	
	
	// old is get
	Route::post('/ajax_event_racer', 'CreateEventController@ajaxinitial')->name('create_event_intial');
	Route::post('/ajax_event_init', 'CreateEventController@initentry')->name('initentry');
	Route::get('/add_category', 'CreateEventController@addCategory')->name('addCategory');
	Route::get('/ajax_event_racer_catdelete', 'CreateEventController@deleteCategory')->name('delcat');
	
	// awards
	Route::post('/ajax_upload_award', 'CreateEventController@uploadAwards')->name('UploadAwards');
	Route::get('/get_all_awards', 'CreateEventController@getAllAwards')->name('getAwards');
	Route::post('/clone_award', 'CreateEventController@clone_award')->name('cloneawards');
	
	Route::post('/ajax_map_box', 'CreateEventController@uploadMap')->name('UploadAwards');
	Route::get('/save_map_code', 'CreateEventController@saveMapgoogleCode')->name('savemapcode');
	Route::get('/delete_map', 'CreateEventController@delete_map')->name('delete_map');
	Route::get('/get_map_by_id/{session_id}/{id}', 'CreateEventController@get_map_by_id')->name('get_map_by_id');
	Route::get('/save_question', 'CreateEventController@save_question')->name('save_question');
	Route::post('/save_shop_product', 'CreateEventController@save_shop_product')->name('productsave');
	Route::get('/check_event_exist', 'CreateEventController@checkEventExist')->name('checkeventexit');

	// SAVE COUPON THE OLD ROUTE IS GET CHANGE TO POST
	Route::POST('/save_coupon_event', 'CreateEventController@save_coupon_event')->name('save_coupon');

	Route::get('/delete_coupon', 'CreateEventController@delete_coupon')->name('save_coupon');
	Route::get('/get_coupon_id', 'CreateEventController@getCouponbyid')->name('getCouponbyid');

	Route::get('/addShippingOption', 'CreateEventController@addShippingOption')->name('addShippingoption');
	Route::get('/deleteShippingOption', 'CreateEventController@deleteShippingOption')->name('addShippingoption');

	// old is GET change to POST because of the description is too big request to handle
	Route::post('/addEventorganizer', 'CreateEventController@addOrganizerEvent')->name('addEventnow');
	
	// ORGANIZER EVENT DETAILS
	Route::post('/view-event-details/{eventid}', 'CreateEventController@view_event_details')->name('view-details');
    Route::get('/view-event-details/{eventid}', 'CreateEventController@view_event_details')->name('view-details');
	
 // Route::get('/get-action-registration/{eventid}', 'CreateEventController@get_action_registration')->name('action-view-details');
//	Route::post('/get-action-registration/{eventid}', 'CreateEventController@get_action_registration')->name('action-view-details');


	Route::post('/view-event-details/{eventid}/{catid}', 'CreateEventController@view_event_details')->name('view-details-cat');
    Route::get('/view-event-details/{eventid}/{catid}', 'CreateEventController@view_event_details')->name('view-details-cat');
    // ORGANIZER EVENT DETAILS

    Route::get('/editprofile', 'ProfileController@editProfile')->name('edit-profile');    
    Route::get('/profileSports', 'ProfileController@profileSports')->name('editprofileSports');
    Route::get('/profileSocial', 'ProfileController@profileSocial')->name('editprofileSocial');

	Route::get('/getProfile', 'ProfileController@getProfile')->name('editgetProfile');
	
	Route::get('/getEventCatList', 'CreateEventController@populate_eventCategory_list')->name('getEventCatList');
	Route::post('/uploadMapimage', 'CreateEventController@uploadMapImage')->name('upMapimage');
	Route::get('/getEventMapList', 'CreateEventController@getEventMapList')->name('eventList');
	Route::get('/getEventAwardList', 'CreateEventController@getEventAwardList')->name('getEventAwardlist');
	Route::get('/getEventQuestion', 'CreateEventController@getEventQuestion')->name('getEventQuestion');
	Route::get('/getEventShop', 'CreateEventController@getEventShop')->name('getEventShop');
	Route::get('/getCouponCode', 'CreateEventController@getCouponCode')->name('getCouponCode');
	Route::get('/getShippingOption', 'CreateEventController@getShippingOption')->name('getshipping');	
	Route::get('/getAwardbyid/{s}/{is}/{tok}', 'CreateEventController@getAwardbyid')->name('getAwardbyid');	
	Route::post('/save_awards_only', 'CreateEventController@save_awards_only')->name('saveonlyawards');	
	Route::get('/call_event_details', 'CreateEventController@call_event_details')->name('call_event_details');
	
	// Event List pwedi mag register usab 
	Route::get('/event-shop/{event_id}/{regid}','RegisterEventController@event_shop_buy')->name('event_shop_buy');
	
	Route::get('/deleteQuestion', 'CreateEventController@deleteQuestion')->name('deleteQuestion');
	
	Route::get('/getQuestion', 'CreateEventController@getQuestion')->name('getQuestion');
	
	Route::get('/addQuestionOnly', 'CreateEventController@addQuestionOnly')->name('addQuestionOnly');
	
	Route::post('/sortquestion', 'CreateEventController@sortquestion')->name('addQuestionOnly');
	
	Route::post('/ajax_upload_question', 'CreateEventController@ajax_upload_question')->name('ajax_upload_question');
	
	//remove 	
	Route::get('/awardsRemove/{e}/{d}', 'CreateEventController@awardsRemove')->name('awardRemove');
	//Route::get('/awardsSaveonly/{ev}/{id}/{sis}', 'CreateEventController@awardsSaveonly')->name('awardsSaveonly');
	
	Route::get('/result-event/{e}', 'CreateEventController@result_event')->name('result-event');
	Route::get('/getQuestionBySession', 'CreateEventController@getQuestionBySession')->name('getQuestionBySession');
	
	// USER WANTS TO REGISTER A CERTAIN EVENT UNDER view-racer-event-details/EVENT_ID
	//Route::get('/racer-register-event', 'RacerRegisterEvent@index')->name('racer-event-register');

	// register route for racer who wants to register for the any event
	Route::get('/event-register/{e}', 'RegisterEventController@index')->name('register-event');
	Route::post('/event-getpost', 'RegisterEventController@process_form_registration')->name('register-post');
	Route::get('/reg-event-thankyou/{id}', 'RegisterEventController@regeventthankyou')->name("regeventthankyou");
	
	// DRAGON PAYMENT SYSTEM HERE 
	Route::get('/dragonpay/', 'DragonpayController@index')->name("paydragon");
	Route::post('/dragonpay/', 'DragonpayController@index')->name("paydragon");

	/** Dragon Pending */
	Route::get('/dragonpay/pending', 'DragonpayController@pending')->name("paydragon.pending");
	Route::post('/dragonpay/pending', 'DragonpayController@pending')->name("paydragon.pending");

	/*
	 DRAGON PAY CALLBAK AFTER PAYING DRAGON PAY AND UPDATE THE TNXID IN TBL-RACER-REGISTRATION TABLE
	*/

	/* PLEASE DONT CHANGE THIS PART - GETTING ERROR IN POST BACK */
	Route::post('/sp', 'DragonpayController@callback')->name("callback");	
	Route::get('/return-sp', 'DragonpayController@returnurl')->name("returnurl");	
 
	Route::get('/add/{type}/{l}/{ev}', 'RegisterEventController@addElement');

	// CATEGORY 
	Route::get('/getCategoryByID', 'CreateEventController@getCategoryByID');
	
	// MAP	for the update only
	Route::get('/save_name_map_only', 'CreateEventController@saveMapOnly');

	// GET THE AMOUNT OF THE CATEGORY LOCATED IN EVENT RACER REGISTRATION 
	Route::get('/get_category_amount', 'RegisterEventController@get_category_amount');
	
	// THE CATEGORY DROPDOWN LIST	
	Route::get('/getCategoryDropdown', 'CreateEventController@getCategoryDropdown');

	// remove item byid
	Route::post('/removeShopByID/{id}', 'CreateEventController@removeShopByID');

	// Get participants under organizer view events	
	Route::get('/getparticipants/{ev}', 'CreateEventController@getparticipants');


	
	// Uppon registration call this router when checking a coupon if you user entitled to use it 
	Route::get('/checkcoupon/{cc}', 'CouponController@index');
	
	// GET ORDER ITEMS UNDER RACER PROFILE ORDER TABS
	Route::get('/getOrderItems/', 'CreateEventController@getOrderItems');
	
	// update profile lock status
	Route::post('/updateProfileLock', 'ProfileController@publicStatus');

	// get profile lock status	
	Route::get('/getProfileLock/', 'ProfileController@status');
	
	// get the full details of the registered user	
	Route::get('/getparticipantsfulldetails/{id}', 'CreateEventController@getparticipantsfulldetails');
	Route::post('/organizer_completed_and_verified/', 'OrganizerController@organizer_completed_and_verified');

	

	// CHANGE IMAGE IN PROFILE 	
	Route::post('/uploadProfileimage/', 'ProfileController@changeImage');

	// update registration status 
	Route::post('/updateracer_registration/', 'RegisterEventController@updateracer_registration');
	
	//
	Route::post('/updateracer_registration_document/', 'RegisterEventController@updateracer_registration_document');
	

	// to complete the pending registration	
	Route::get('/registration-complete-action/', 'RegisterEventController@registration_complete_action');
	Route::post('/updateracer_registration_receipt/', 'RegisterEventController@updateracer_registration_receipt');
	
	// update bank account details 
	Route::post('/savebankAccountdetails/', 'BankAccountController@savebankAccountdetails');
	Route::get('/savebankAccountdetails/', 'BankAccountController@getbankaccounts');

	// SUBMIT REGISTRATION STATUS
	Route::post('/reg-status-success/', 'RegisterEventController@registration_status_submit')->name('reg-status-success');
	
	// GET THE REGISTRATION DETAILS WHEN CLICKING PENDING BUTTON IN PROFILE PAGE	
	Route::get('/getRegistrationDetails/{id}', 'RegisterEventController@getRegistrationdetails');
	Route::get('/getShoppedpendingpayment/{id}', 'ShopController@getShoppedPendingPayment');
	// CHANGE PAYMENT METHOD UNDER THE REGISTRATION STATUS MODAL 
	// CHANGE IT TO BANK DEPOSIT,PAYPAL,RACEYAYA PAYMENT PORTAL,CHECK PAYMENT
	Route::get('/changepaymentmethod/', 'RegisterEventController@payment_method_change');
	
	// PAYPAL PAYMENT
	// new paypal 
	Route::get('payment', 'PayPalCreditController@getCheckout')->name('payment');
	//Route::get('/pc-paypal', 'PayPalCreditController@getCheckout');
	Route::get('/getDone', 'PayPalCreditController@getDone')->name('getback');
	Route::get('/getCancel', ['as'=>'getCancel','uses'=>'PayPalCreditController@getCancel']);
	
	/*Route::get('payment', 'PayPalController@payment')->name('payment');
	Route::get('welcome', 'PayPalController@welcome')->name('welcome');	
	Route::get('cancel', 'PayPalController@cancel')->name('payment.cancel');
	Route::get('payment-pending/{ev}', 'PayPalController@payment_pending')->name('payment_pending');
	Route::get('payment/success', 'PayPalController@success')->name('payment.success');
	Route::get('paypal/success', 'PayPalController@successbuyonly')->name('payment.pending_success');
	*/
	// AUTHORIZE.NET PAYMENT
	//Route::get('/checkout', 'AuthorizeController@index');
	Route::get('/checkout', 'AuthorizeController@chargeCreditCard')->name('checkout');
	Route::get('/checkout-pending/{ev}', 'AuthorizeController@processPending')->name('checkout.pending');

	// INSERT BANK ACCOUNT ROW
	Route::get('/insertBankAccountRow', 'BankAccountController@insert_row')->name('insert_row');
	Route::post('/insertBankAccountData', 'BankAccountController@insertBankAccountData')->name('insert_row');	

	
	// API LIST QUERY FOR THE ORGANIZER 
	Route::get('/API/getEvetns', 'ApiEventController@getAllEvents')->name('api_get_all_events');


	Route::get('/showlist', 'AlexController@index');

	// Check the registration status of the racer for login racer 
	Route::get('/getregisterstatus', 'CreateEventController@checkracer_pending')->name('checkifpending');
	Route::get('/getRegistration_documentDetails', 'RegisterEventController@getRegistration_documentDetails')->name('check_user_details');

	// PAYPAL ACCOUNTS MODAL LOCATED IN PAYMENT METHOD DURING EVENT CREATION USE BY ORGANIZER	
	Route::post('/savepaypalaccount', 'PayPalController@savepayAccount');
	Route::get('/getpaypalAccount', 'PayPalController@getpaypalAccount');

	// PAYPAL ACCOUNTS MODAL LOCATED IN PAYMENT METHOD DURING EVENT CREATION USE BY ORGANIZER	
	Route::post('/saveauthorizeccount', 'AuthorizeController@saveAuthorizeaccount');
	Route::get('/saveauthorizeccount', 'AuthorizeController@getAuthorizeaccount');
	
	//SHOP ENABLE OR DISABLE SETTING FOR THE ORGANIZER	
	Route::post('/shopstatus_enable_disable', 'ShopController@enable_disable');

	// SHIPPING ENABLE OR DISABLE SETTING FOR THE ORGANIZER	
	Route::post('/shippingstatus_enable_disable', 'ShippingController@enable_disable');

	// ADD PRODUCT COLOR ATTRIBUTES FOR THE SHOP	
	Route::post('/addproductcolor', 'ShopController@insertColorattribute');
	Route::get('/removeProductColor', 'ShopController@removeentry');
	Route::get('/getproductsizeandquantiy', 'ShopController@getSizeQuantity');
	Route::post('/savesizesqty', 'ShopController@savesizesqty');
	Route::post('/removesizeQty', 'ShopController@removesizeQty');
	Route::get('/getproductByid', 'ShopController@getProductById');	
	Route::post('/updateColor','ShopController@updateColor');
	Route::post('/shop-product-update','ShopController@shop_product_update'); /** update of the product without image */	
	Route::get('/getremaining','ShopController@getremaining'); /** update of the product without image */
	
	Route::get('/getproductvariants','ShopController@getproductvariants'); /** update of the product without image */
	Route::POST('/sethasvariants','ShopController@sethasvariants');
	Route::post('/save_new_variant_product','ShopController@newvariantproduct'); /** update of the product without image */
	
	// NEW ROUTE FOR NEW VARIANT VERSION 	
	Route::POST('/savenew_variant','ShopController@save_new_variant_option');  /** update of the product without image */
	Route::get('/save_variant_default','ShopController@save_variant_default'); /** update of the product shop without image */
	// ADD PRODUCT COLOR ATTRIBUTES FOR THE SHOP
	
	// REGISTRATION EVENT SAVE TEMP DATA
	Route::post('/save_registration_temp','RegisterEventController@save_registration_temp');

	Route::post('/saveCart','RegisterEventController@saveCart');
	
	Route::get('/getcart','RegisterEventController@getcart');
	Route::get('/deletecart','RegisterEventController@deletecart');
	Route::post('/calculate_discount','RegisterEventController@calculate_discount');
	
	// GET THE REGISTRATION INFO WHEN THE FIRST STEP IS CLICK DIDTO NI SA EVENT REGISTRATION
	Route::get('/getregistration_info','RegisterEventController@getregistrationinfo');
	Route::get('/calculate_cart','RegisterEventController@calculate_cart');
	
	// DRAGON PAY 
	Route::get('/dragon-confirm','DragonpayController@confirmDragon')->name('dc.confirm');
	Route::get('/dragon-cancel','DragonpayController@cancel')->name('dc.cancel');

	// ADD WEB FEE
	Route::post('/addweb_fee_amount','OrganizerOpenController@addwebfee');
	 
	/**
	 * 		RACE TIMING ROUTE LIST HERE
	 * 
	 */
});


	Route::get('/getevents', 'CreateEventController@getEventDetails');
	Route::get('/term-of-use-and-services', 'SiteController@term_of_use')->name('term.of.use');
	Route::post('/shop-order-inquiry', 'SiteController@inquiry')->name('shop.inquire');

	// SHOW THE PROFILE OF THE RACER 
	Route::get('/getracerprofile', 'RacerOpenController@checkregister')->name('openprofile');
	Route::get('/ry/{id}/{id2}', 'RacerOpenController@getPublicProfile')->name('getPublicProfile');

	Route::get('/vi/{id}/{org}', 'OrganizerOpenController@getPublicProfile');
	
	// PAYPAL CREDIT PAYMENT
	// Route::get('getCheckout', 'PayPalCreditController@getCheckout')->name('getCheckout');

	Route::get('/cc', 'RacerController@bite')->name('cc');

	// FRONT END EVENT RELATED UNAUTH QUERY API
	// Route::get('/api/event', 'QueryEventController@index')->name('frontquery');

	Route::get('/api/event', 'CreateEventController@call_event_details')->name('frontquery');

	Route::get('laravel-send-email', 'EmailController@sendEMail');
	
	// race result route reserved
	Route::get('/race-result', 'RaceController@index')->name('race-result');

	// races page then view event detail
	Route::get('/view-racer-event-details/{eventid}', 'CreateEventController@view_event_racer_details')->name('racer-view-details');

	// vuejs
	Route::get('/timbal', 'SinglePageController@index');
	Route::get('/racer-register', 'RegisterRacerController@index')->name('regRacer');
	Route::post('/racer-register', 'RegisterRacerController@index')->name('regRacer');
	Route::get('/about', 'AboutController@index')->name('about');
	Route::post('/contact', 'ContactController@index')->name('send-contact');
	Route::get('/contact', 'ContactController@index')->name('Contact');

	Route::get('/organizers', 'OrganizerController@index')->name('Organizers');

	// Route::get('/organizers/{id}', 'OrganizerController@organizerDetails')->name('Organizers-details');

	Route::get('/check_application', 'ApplicationStatusController@index')->name('check_application');
	//Route::get('/racer-resources', 'ResourcesController@index')->name('resources');
	Route::get('/checkApplicationStatus', 'OrganizerController@checkApplicationStatus')->name('check_applistatus');

	//Route::get('paginate', 'PaginateController@index');
	//Route::get('onclick', 'PaginateController@onclick');

	Route::get('/getCurrency',"CurrencyController@index");

	// Route::get('/racers', 'FrontRacerController@index')->name('front-racer');
	// PARA SA DYNAMIC SLUG PAGES PARA SA SEO
	Route::get('/thankyou', 'FinalMsgController@index')->name('thankyou');
	Route::get('/blog', 'BlogController@index')->name('blog');

	// Front-list-racersCHEC
	Route::post('/ry/racers', 'FrontRacerController@racers_list')->name('racers-list');

	Route::get('/ry/racers', 'FrontRacerController@racers_list')->name('racers-list');
	Route::post('ckeditor/upload', 'CkeditorController@upload')->name('ckeditor.upload');

	// FRONT-END PAGE EVENTS 
	Route::post('/events', 'FrontRacerController@index')->name('front-racer-post');
	Route::get('/events', 'FrontRacerController@index')->name('front-racer');

	// SOCIALITE 
	Route::get('/auth/redirect/{provider}', 'SocialController@redirect');
	//Route::get('/auth/api/{provider}', 'SocialController@redirect');
	Route::get('/callback/{provider}', 'SocialController@callback');	 
	Route::get('/login/facebook/callback', function () {
		 return redirect('/');
	});
	// SOCIALITE 
		
	Route::get('/{slug}', 'FourOfourController@index');
	Route::get('/{slug}/{id}', 'FourOfourController@index');