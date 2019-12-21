<div class="left_col scroll-view">
  <div class="navbar nav_title" style="border: 0;">
    <a href="" class="site_title"></i> <span>{{ Helper::setting()->name }} </span></a>
  </div>

  <div class="clearfix"></div>
  <br />

  <!-- sidebar menu -->
  <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
      <!-- <h3>General</h3> -->
      <ul class="nav side-menu">

        <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <!-- User Management Sidebar -->
        @if(auth()->user()->hasPermission('view.roles') || auth()->user()->hasPermission('view.users'))
					<li><a><i class="fa fa-users"></i>User Management <span class="fa fa-chevron-down"></span></a>
						<ul class="nav child_menu">
							@permission('view.roles')
							<li><a href="{{url('role')}}"> Role / Permission</a></li>
							@endpermission
							@permission('view.users')
							<li><a href="{{url('user')}}"> User</a></li>
							@endpermission
						</ul>
					</li>
				@endif
        <!-- <li><a href="{{url('/user')}}"><i class="fa fa-user"></i> User</a></li> -->
        <li><a href="{{url('/city')}}"><i class="fa fa-building"></i> City</a></li>
        <li><a href="{{url('/dealer')}}"><i class="fa fa-users"></i> Dealer</a></li>
        <li><a href="{{url('/category')}}"><i class="fa fa-list"></i> Category</a></li>
        <li><a href="{{url('/product')}}"><i class="fa fa-th-large"></i> Product</a></li>
        <li><a href="#"><i class="fa fa-user"></i> Party Master</a></li>
        <li><a href="{{url('/order')}}"><i class="fa fa-shopping-cart"></i> Order</a></li>
        <li><a href="#"><i class="fa fa-user"></i> Stock Adjustment/Purchase</a></li>
        <li><a href="{{url('/settings')}}"><i class="fa fa-cog"></i> Settings</a></li>
        <li><a href="#"><i class="fa fa-user"></i> Report</a></li>
      </ul>
    </div>
  </div>
  <!-- /sidebar menu -->
</div>
