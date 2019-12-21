@extends('layouts.master')
@section('title')
{{$moduleName}}
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
      @if (Session::has('message'))
      <div class="alert alert-success">
          <button type="button" class="close" data-dismiss="alert">
              <i class="ace-icon fa fa-times"></i>
          </button>
              {!! session('message') !!}
      </div>
      @endif
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>{{$moduleName }}</h2>
              <div><a href="{{route('city.create')}}"><button class="btn btn-primary" style="float:right;"><i class="fa fa-plus"></i> New</button></a></div>
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
                          <th>SrNo</th>
                          <th>Name</th>
                          <th>Action</th>
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
  datatable=$('.datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{url('/getCityData') }}",
        columns: [
          { data: 'DT_RowIndex',searchable: false,orderable: false},
          { data: 'name'},
          { data: 'action',orderable: false, searchable: false},
        ],
    });

  $(document).on("click", ".confirm-delete", function (e) {
    var id = $(this).data("id");
    e.preventDefault();
      swal({
        title: "Are you sure want to delete?",
        text: "Once delete, action can not be undone!!!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: "{{url($route)}}"+'/'+id,
            type: 'DELETE',
            dataType:'json',
            data: {id:id},
            success: function(res){
              if(res == true){
                $('.datatable').DataTable().ajax.reload();
                swal("Success", "Record Deleted Successfully!", "success");
              }
              else{
                if('{{$route}}' == 'city'){
                  swal("Warning", "City is Already Used in Dealer so, Can Not be Deleted", "warning");
                } else {
                  swal("Error", "Some Problem Occured...Please Try Again", "error");
                }

              }
            }
          });
        }
      });
  });

});

</script>
@endsection