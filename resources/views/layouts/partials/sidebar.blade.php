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

        <li><a href="{{ url('home') }}"><i class="fa fa-home"></i> {{ trans('sidebar.dashboard') }}</a></li>
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> {{ trans('sidebar.firm_master') }}</a></li>
        <!-- User Management Sidebar -->
        @if(auth()->user()->hasPermission('view.roles') || auth()->user()->hasPermission('view.users'))
            <li><a><i class="fa fa-users"></i> {{ trans('sidebar.user_management') }}<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    @permission('view.roles')
                    <li><a href="{{url('role')}}"> {{ trans('sidebar.role_permission') }}</a></li>
                    @endpermission
                    @permission('view.users')
                    <li><a href="{{url('user')}}"> {{ trans('sidebar.user') }}</a></li>
                    @endpermission
                </ul>
            </li>
        @endif

        @if(auth()->user()->hasPermission('view.states') || auth()->user()->hasPermission('view.cities') || auth()->user()->hasPermission('view.parties') || auth()->user()->hasPermission('view.category') || auth()->user()->hasPermission('view.product'))
        <li><a><i class="fa fa-arrows"></i> {{ trans('sidebar.master') }} <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                @permission('view.states')
                <li><a href="{{ url('state') }}"> {{ trans('sidebar.state_master') }}</a></li>
                @endpermission
                @permission('view.cities')
                <li><a href="{{ url('city') }}"> {{ trans('sidebar.city_master') }}</a></li>
                @endpermission
                @permission('view.parties')
                <li><a href="{{ url('party') }}"> {{ trans('sidebar.party_master') }}</a></li>
                @endpermission
                @permission('view.category')
                <li><a href="{{ url('category') }}"> {{ trans('sidebar.category') }}</a></li>
                @endpermission
                @permission('view.product')
                <li><a href="{{ url('product') }}"> {{ trans('sidebar.product') }}</a></li>
                @endpermission
            </ul>
        </li>
        @endif
		@permission('view.order')
			<li><a href="{{url('order')}}"><i class="fa fa-shopping-cart"></i> {{ trans('sidebar.orders') }}</a></li>
		@endpermission
        @permission('view.purchases')
          	<li><a href="{{url('purchase')}}"><i class="fa fa-line-chart"></i> {{ trans('sidebar.stock_purchase') }}</a></li>
        @endpermission
        @if(auth()->user()->hasPermission('view.partywisereport') || auth()->user()->hasPermission('view.productwisereport') || auth()->user()->hasPermission('view.datewisereport') || auth()->user()->hasPermission('view.citywisereport'))
          <li><a><i class="fa fa-bar-chart"></i> {{ trans('sidebar.reports') }} <span class="fa fa-chevron-down"></span></a>
              <ul class="nav child_menu">
                  @permission('view.partywisereport')
                    <li><a href="{{ url('partywisereport') }}"> {{ trans('sidebar.party_report') }}</a></li>
                  @endpermission
                  @permission('view.productwisereport')
                    <li><a href="{{ url('productwisereport') }}"> {{ trans('sidebar.product_report') }}</a></li>
                  @endpermission
                  @permission('view.datewisereport')
                    <li><a href="{{ url('datewisereport') }}"> {{ trans('sidebar.date_report') }}</a></li>
                  @endpermission
                  @permission('view.citywisereport')
                    <li><a href="{{ url('citywisereport') }}"> {{ trans('sidebar.city_report') }}</a></li>
                  @endpermission
              </ul>
          </li>
        @endif
        <li><a href="{{url('settings')}}"><i class="fa fa-cog"></i> {{ trans('sidebar.setting') }}</a></li>
      </ul>
    </div>
  </div>
  <!-- /sidebar menu -->
</div>
