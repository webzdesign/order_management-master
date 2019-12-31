@extends('layouts.master')
@section('title')
{{$moduleName}} - {{ Helper::setting()->name }}
@endsection
@section('content')
<div class="right_col" role="main">
    <div class="page-title">
        <div class="title_left"></div>
        <div class="title_right"></div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{ trans('product.detail', [ 'module' => $moduleName ]) }}</h2>
                    <div>
                        @permission('create.product')
                        <a href="{{ route('product.create') }}"><button class="btn btn-primary" style="float:right;"><i class="fa fa-plus"></i> {{ trans('product.btn.New') }}</button></a>
                        @endpermission
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box table-responsive">
                                <table class="datatable mdl-data-table dataTable table table-striped table-bordered" cellspacing="0"
                                width="100%" role="grid" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>{{ trans('product.tfield.sr_no') }}</th>
                                            <th>{{ trans('product.tfield.cat_name')}}</th>
                                            <th>{{ trans('product.tfield.product_name')}}</th>
                                            <th>{{ trans('product.tfield.opening_stock')}}</th>
                                            <th>{{ trans('product.tfield.price')}}</th>
                                            <th>{{ trans('product.tfield.status')}}</th>
                                            <th>{{ trans('product.tfield.added_by')}}</th>
                                            <th>{{ trans('product.tfield.action')}}</th>
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
        title: '{{ trans("product.product") }}',
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
        ajax: "{{url('getProductData') }}",
        columns: [
          { data: 'DT_RowIndex',searchable: false,orderable: false},
          { data: 'category.name'},
          { data: 'name'},
          { data: 'op_stock'},
          { data: 'price'},
          { data: 'status'},
          { data: 'user.name'},
          { data: 'action',orderable: false, searchable: false},
        ],
    });

    $(document).on('click', '#active', function(e) {
        e.preventDefault();
        var linkURL = $(this).attr("href");
        swal({
            title: "{{ trans('product.message.active_title') }}",
            text: "{{ trans('product.message.active_text') }}",
            icon: "success",
            buttons: true,
            dangerMode: true,
            buttons: [ "{{ trans('product.btn.Cancel') }}" , "{{ trans('product.btn.ok') }}"]
        })
        .then((willActive) => {
            if (willActive) {
                window.location.href = linkURL;
            }
        });
    });


    $(document).on('click', '#deactive', function(e) {
        e.preventDefault();
        var linkURL = $(this).attr("href");
        swal({
            title: "{{ trans('product.message.deactive_title') }}",
            text: "{{ trans('product.message.deactive_text') }}",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            buttons: [ "{{ trans('product.btn.Cancel') }}" , "{{ trans('product.btn.ok') }}"]
        })
        .then((willDeactivate) => {
            if (willDeactivate) {
                window.location.href = linkURL;
            }
        });
    });
});

</script>
@endsection
