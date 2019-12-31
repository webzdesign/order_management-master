@extends('layouts.master')
@section('title')
{{ trans('dashboard.detail', [ 'module' => $moduleName ]).' - '.Helper::setting()->name  }}
@endsection
@section('content')

<div class="right_col" role="main">
  	<div class="">
		<div class="page-title">
			<div class="title_left"></div>
			<div class="title_right"></div>
		</div>
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2>{{ trans('dashboard.dashboard') }}</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<div class="row">
							<div class="row top_tiles">
								<a href="{{ url('user') }}">
									<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
										<div class="tile-stats">
											<div class="icon"><i class="fa fa-users"></i></div>
											<div class="count">{{ $userCount }}</div>
											<p></p>
											<h3 class="titleClass">{{ trans('dashboard.active_users') }}</h3>
										</div>
									</div>
								</a>
								<a href="{{ url('order') }}">
									<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
										<div class="tile-stats">
											<div class="icon"><i class="fa fa-shopping-cart"></i></div>
											<div class="count">{{ $totalOrder }}</div>
											<p></p>
											<h3 class="titleClass">{{ trans('dashboard.total_order') }}</h3>
										</div>
									</div>
                                </a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
  	</div>
</div>
@endsection
