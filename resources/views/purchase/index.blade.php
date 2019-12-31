@extends('layouts.master')
@section('title')
{{ trans('stockpurchase.detail', [ 'module' => $moduleName ]).' - '.Helper::setting()->name  }}
@endsection
@section('content')
<div class="right_col" role="main">
  <div class="">
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
            <h2>{{ trans('stockpurchase.detail', [ 'module' => $moduleName ]) }} </h2>
              @permission('create.purchases')
                <div><a href="{{route('purchase.create')}}"><button class="btn btn-primary" style="float:right;"><i class="fa fa-plus"></i> {{ trans('stockpurchase.btn.New') }}</button> </a></div>
              @endpermission
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
                          <th>{{ trans('stockpurchase.tfield.sr_no') }}</th>
                          <th>{{ trans('stockpurchase.tfield.purchase_id') }}</th>
                          <th>{{ trans('stockpurchase.tfield.date') }}</th>
                          <th>{{ trans('stockpurchase.tfield.product') }}</th>
                          <th>{{ trans('stockpurchase.tfield.qty') }}</th>
                          <th>{{ trans('stockpurchase.tfield.added_by') }}</th>
                          <th>{{ trans('stockpurchase.tfield.action') }}</th>
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
        title: '{{ trans("stockpurchase.purchase") }}',
        text: '{!! session('message') !!}',
        type: 'success',
        styling: 'bootstrap3',
        delay: 1500,
        animation: 'fade',
        animateSpeed: 'slow'
    });
    @endif

  datatable=$('.datatable').DataTable({
        processing: true,
        serverSide: true,
        "language": {
              "url": lang_url
          },
        ajax: "{{url('/getPurchaseData') }}",
        columns: [
          { data: 'DT_RowIndex',searchable: false,orderable: false},
          { data: 'purchase_id'},
          { data: 'date'},
          { data: 'product.name'},
          { data: 'qty'},
          { data: 'user.name'},
          { data: 'action',orderable: false, searchable: false},
        ],
    });

    $(document).on('click', '#deletepurchase', function(e) {
        e.preventDefault();
        var linkURL = $(this).attr("href");
        swal({
            title: "{{ trans('stockpurchase.alert.confirm_delete') }}",
            text: "{{ trans('stockpurchase.alert.confirm_text') }}",
            icon: "success",
            buttons: true,
            dangerMode: true,
            buttons: [ "{{ trans('stockpurchase.alert.cancel_alert') }}" , "{{ trans('stockpurchase.alert.confirm_alert') }}"]
        })
        .then((willActive) => {
            if (willActive) {
                window.location.href = linkURL;
            }
        });
    });
});

</script>
@endsection