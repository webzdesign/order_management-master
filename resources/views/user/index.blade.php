@extends('layouts.master')
@section('title')
{{ trans('user.detail', [ 'module' => $moduleName ]).' - '.Helper::setting()->name  }}
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
            <h2>{{ trans('user.detail', [ 'module' => $moduleName ]) }} </h2>
            @permission('create.users')
              <div><a href="{{route('user.create')}}"><button class="btn btn-primary" style="float:right;"><i class="fa fa-plus"></i> {{ trans('user.btn.New') }}</button></a></div>
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
                          <th>{{ trans('user.tfield.sr_no') }}</th>
                          <th>{{ trans('user.tfield.name') }}</th>
                          <th>{{ trans('user.tfield.email') }}</th>
                          <th>{{ trans('user.tfield.status') }}</th>
                          <th>{{ trans('user.tfield.user_role') }}</th>
                          <th>{{ trans('user.tfield.action') }}</th>
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
        title: '{{ trans("user.user") }}',
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
          ajax: "{{url('/getUserData') }}",
          columns: [
            { data: 'DT_RowIndex',searchable: false,orderable: false},
            { data: 'name'},
            { data: 'email'},
            { data: 'status'},
            { data: 'user.role', name:'roles.name'},
            { data: 'action',orderable: false, searchable: false},
          ],
      });

  /** Active Deactive Message */

 $(document).on('click', '#active', function(e) {
  e.preventDefault();
  var linkURL = $(this).attr("href");
  swal({
      title: "{{ trans('user.alert.confirm_activate') }}",
      text: "{{ trans('user.alert.confirm_text') }}",
      icon: "success",
      buttons: true,
      dangerMode: true,
      buttons: [ "{{ trans('user.alert.cancel_alert') }}" , "{{ trans('user.alert.confirm_alert') }}"]
  })
  .then((willDelete) => {
      if (willDelete) {
          window.location.href = linkURL;
      }
  });
});


$(document).on('click', '#deactive', function(e) {
  e.preventDefault();
  var linkURL = $(this).attr("href");
  swal({
      title: "{{ trans('user.alert.confirm_deactivate') }}",
      text: "{{ trans('user.alert.confirm_text') }}",
      icon: "warning",
      buttons: true,
      dangerMode: true,
      buttons: [ "{{ trans('user.alert.cancel_alert') }}" , "{{ trans('user.alert.confirm_alert') }}"]
  })

  .then((willDelete) => {
      if (willDelete) {
          window.location.href = linkURL;
      }
  });
});


  });

</script>
@endsection