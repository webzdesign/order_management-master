@extends('layouts.master')
@section('title')
{{$moduleName}}
@endsection
@section('content')
<div class="right_col" role="main">
	<div class="page-title">
		<div class="title_left">
		</div>
		<div class="title_right">
		</div>
	</div>
	<div class="clearfix"></div>

	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
                    <h2><i class="fa fa-bars"></i>{{ trans('role.detail', [ 'module' => $moduleName ]) }}</h2>
                    @permission('create.roles')
                        <div><a href="{{route('role.create')}}"><button class="btn btn-primary" style="float:right;"><i class="fa fa-plus"></i>  {{ trans('role.btn.New') }}</button></a></div>
                    @endpermission
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
                    <div class="card-box table-responsive">
                        <table class="datatable mdl-data-table dataTable table table-striped table-bordered" cellspacing="0"
                        width="100%" role="grid" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>{{ trans('role.tfield.sr_no') }}</th>
                                    <th>{{ trans('role.tfield.name')}}</th>
                                    <th>{{ trans('role.tfield.description')}}</th>
                                    <th>{{ trans('role.tfield.action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script>
$(document).ready(function() {

    var lang_url = "";
    var lang_type  = "{{ Session::get('locale')}}";
    if (lang_type == 'en') {
        lang_url = "{{ url('/resources/lang/en/datatable_en.json') }}";
    } else {
        lang_url = "{{ url('/resources/lang/gu/datatable_gj.json') }}";
    }
    @if (Session::has('message'))
    new PNotify({
        title: '{{ trans("role.role") }}',
        text: '{!! session('message') !!}',
        type: 'success',
        styling: 'bootstrap3',
        delay: 1500,
        animation: 'fade',
        animateSpeed: 'slow'
    });
    @endif

    $('.datatable').DataTable({
        processing: true,
        serverSide: true,
        "language": {
			"url": lang_url
		},
        ajax: "{{url('getRoleData') }}",
        columns: [
        { data: 'DT_RowIndex',searchable: false,orderable: false},
		{ data: 'name'},
		{ data: 'description'},
        { data: 'action',orderable: false, searchable: false},
        ],
    });
});
</script>
@endsection
