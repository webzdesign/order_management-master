<div class="left_col scroll-view">
  <div class="navbar nav_title" style="border: 0;">
    <a href="" class="site_title"></i> <span>{{ Helper::setting()->name }} </span></a>
  </div>

  <div class="clearfix"></div>
  <!-- sidebar menu -->
  <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
      <!-- <h3>General</h3> -->
      <ul class="nav side-menu">

        <li><a href="{{ url('home') }}"><i class="fa fa-home"></i> Dashboard</a></li>
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Firm Master</a></li>
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

        @if(auth()->user()->hasPermission('view.states') || auth()->user()->hasPermission('view.cities') || auth()->user()->hasPermission('view.parties') || auth()->user()->hasPermission('view.category') || auth()->user()->hasPermission('view.product'))
        <li><a><i class="fa fa-arrows"></i>Masters <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                @permission('view.states')
                <li><a href="{{ url('state') }}"> State Master</a></li>
                @endpermission
                @permission('view.cities')
                <li><a href="{{ url('city') }}"> City Master</a></li>
                @endpermission
                @permission('view.parties')
                <li><a href="{{ url('party') }}"> Party Master</a></li>
                @endpermission
                @permission('view.category')
                <li><a href="{{ url('category') }}"> Category</a></li>
                @endpermission
                @permission('view.product')
                <li><a href="{{ url('product') }}"> Product</a></li>
                @endpermission
            </ul>
        </li>
        @endif
		@permission('view.order')
			<li><a href="{{url('order')}}"><i class="fa fa-shopping-cart"></i> Orders</a></li>
		@endpermission
        @permission('view.purchases')
          	<li><a href="{{url('purchase')}}"><i class="fa fa-line-chart"></i> Stock Adjustment / Purchase</a></li>
        @endpermission
        <li><a><i class="fa fa-bar-chart"></i>Reports <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                @permission('view.partywisereport')
                  <li><a href="{{ url('partywisereport') }}"> Party Wise Report</a></li>
                @endpermission
                <li><a href="{{ url('productwisereport') }}"> Product Wise Report</a></li>
                <li><a href="{{ url('') }}"> Date Wise Report</a></li>
                <li><a href="{{ url('') }}"> City Wise Report</a></li>
            </ul>
        </li>
        <li><a href="{{url('settings')}}"><i class="fa fa-cog"></i> Settings</a></li>
      </ul>
    </div>
  </div>
  <!-- /sidebar menu -->
</div>
