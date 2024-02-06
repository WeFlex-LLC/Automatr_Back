<div class="sidebar-wrapper">
	<div>
		<div class="logo-wrapper">
			<a href="{{route('/')}}"><img class="img-fluid for-light" src="{{asset('assets/images/logo/logo.png')}}" alt=""><img class="img-fluid for-dark" src="{{asset('assets/images/logo/logo_dark.png')}}" alt=""></a>
			<div class="back-btn"><i class="fa fa-angle-left"></i></div>
			<div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
		</div>
		<div class="logo-icon-wrapper"><a href="{{route('/')}}"><img class="img-fluid" src="{{asset('assets/images/logo/logo-icon.png')}}" alt=""></a></div>
		<nav class="sidebar-main">
			<div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
			<div id="sidebar-menu">
				<ul class="sidebar-links" id="simple-bar">
					<li class="back-btn">
						<a href="{{route('/')}}"><img class="img-fluid" src="{{asset('assets/images/logo/logo-icon.png')}}" alt=""></a>
						<div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
					</li>
					<li class="sidebar-main-title">
						<div>
							<h6 class="lan-1">{{ trans('lang.General') }}  </h6>
                     		<p class="lan-2">{{ trans('lang.Dashboards,widgets & layout.') }}</p>
						</div>
					</li>
					@if(auth()->user()->email == "vladevoyan@hotmail.com")
					<li class="sidebar-list">
						<a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/automation' ? 'active' : '' }}" href="#"><i data-feather="cpu"></i><span class="lan-3">Automations</span>
							<div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/automation' ? 'down' : 'right' }}"></i></div>
						</a>
						<ul class="sidebar-submenu">
							<li><a class="lan-3 " href="/admin/category/list">Categories</a></li>
							<li><a class="lan-4" href="/admin/automation/list">Automations</a></li>
							<li><a class="lan-5" href="/admin/type/list">Types</a></li>
                     		
						</ul>
					</li>
					<li class="sidebar-list">
						<a class="sidebar-link sidebar-title {{ request()->route()->getPrefix() == '/page-layouts' ? 'active' : '' }}" href="#"><i data-feather="user"></i>
							<span class="lan-7">User Management</span>
							<div class="according-menu"><i class="fa fa-angle-{{ request()->route()->getPrefix() == '/page-layouts' ? 'down' : 'right' }}"></i></div>
						</a>
	                    <ul class="sidebar-submenu">
                          <li><a href="/admin/manage/list" class="lan-6">Admin Management</a></li>
                          <li><a href="#" class="lan-7">User Management</a></li>
                      </ul>
                  	</li>
					  <li class="sidebar-list">
						<a class="sidebar-link sidebar-title {{ request()->route()->getPrefix() == '/page-layouts' ? 'active' : '' }}" href="#"><i data-feather="user"></i>
							<span class="lan-7">Package Management</span>
							<div class="according-menu"><i class="fa fa-angle-{{ request()->route()->getPrefix() == '/page-layouts' ? 'down' : 'right' }}"></i></div>
						</a>
	                    <ul class="sidebar-submenu">
                          <li><a href="/admin/package/list" class="lan-6">Package Management</a></li>
                          <li><a href="/admin/package/user" class="lan-7">Package User Management</a></li>
                      </ul>
                  	</li>
					  @endif
					  <li class="sidebar-list">
						<a class="sidebar-link sidebar-title {{ request()->route()->getPrefix() == '/page-layouts' ? 'active' : '' }}" href="#"><i data-feather="layout"></i>
							<span class="lan-7">Content Management</span>
							<div class="according-menu"><i class="fa fa-angle-{{ request()->route()->getPrefix() == '/page-layouts' ? 'down' : 'right' }}"></i></div>
						</a>
	                    <ul class="sidebar-submenu">
                          <li><a href="/admin/helpCenter/list" class="lan-6">Help Center Management</a></li>
                          <li><a href="/admin/blog/list" class="lan-7">Blog Management</a></li>
						  <li><a href="/admin/tag/list" class="lan-7">Blog Tag Management</a></li>
                      </ul>
                  	</li>
					
					
				</ul>
			</div>
			<div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
		</nav>
	</div>
</div>