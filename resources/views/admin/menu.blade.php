<ul class="admin_list">
    <li><a href="{{ route('admin') }}">Dashboard</a></li>
    @if(Route::currentRouteName() == 'admin_users')						
         <li><a style="color:#fff;background:#37bdf2" href="{{ route('admin_users') }}">User list</a></li>
    @else 
        <li><a href="{{ route('admin_users') }}">User list</a></li>
    @endif
    
    @if(Route::currentRouteName() == 'admin_organizer_list')						
         <li><a style="color:#fff;background:#37bdf2" href="{{ route('admin_organizer_list') }}">Organizer List</a></li>
    @else 
         <li><a href="{{ route('admin_organizer_list') }}">Organizer List</a></li>
    @endif
    
    @if(Route::currentRouteName() == 'admin_boost_list')						
         <li><a style="color:#fff;background:#37bdf2" href="{{ route('admin_boost_list') }}">Boost List</a></li>
    @else 
         <li><a href="{{ route('admin_boost_list') }}">Boost List</a></li>
    @endif
    
    @if(Route::currentRouteName() == 'admin_signup_list')						
         <li><a style="color:#fff;background:#37bdf2;" href="{{ route('admin_signup_list') }}">Sign Up List</a></li>
    @else 
         <li><a href="{{ route('admin_signup_list') }}">Sign Up List</a></li>
    @endif
    
    @if(Route::currentRouteName() == 'admin_event_list')						
         <li><a style="color:#fff;background:#37bdf2;" href="{{ route('admin_event_list') }}">Event List</a></li>
    @else 
         <li><a href="{{ route('admin_event_list') }}">Event List</a></li>
    @endif
	
	@if(Route::currentRouteName() == 'admin_category')						
         <li><a style="color:#fff;background:#37bdf2;" href="{{ route('admin_category') }}">Category</a></li>
    @else 
         <li><a href="{{ route('admin_category') }}">Category</a></li>
    @endif
</ul>