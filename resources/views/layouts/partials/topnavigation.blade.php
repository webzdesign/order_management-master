<!-- top navigation -->
<div class="top_nav">
  <div class="nav_menu">
    <nav>
      <div class="nav toggle">
        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
      </div>

      <ul class="nav navbar-nav navbar-right">
        <li class="">
          <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
          <span class="fa fa-angle-down"></span> {{ auth()->user()->name }}
          </a>
          <ul class="dropdown-menu dropdown-usermenu pull-right">
            <li><a href="{{ url('changepassword') }}"><i class="fa fa-key pull-right"></i> Change Password</a></li>
            <li><a href="{{ route('logout') }}"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
            </li>

          </ul>
        </li>
        <form id="logout-form" action="{{ route('logout') }}"
        method="POST" style="display: none;">
          @csrf
        </form>
      </ul>
    </nav>
  </div>
</div>
<!-- /top navigation -->