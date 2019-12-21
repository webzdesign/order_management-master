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
                          <th>Order No</th>
                          <th>Date</th>
                          <th>Dealer Name</th>
                          <th>City</th>
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


<div class="modal fade bs-example-modal-sm" id="qty_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

        <div class="modal-header">
            <button type="button" class="close remove_validation" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel2">Dispatch Qty</h4>
        </div>
        <form id="frm_modal" method="post" name="frm_modal" autocomplete="off">
          @csrf
          <input type="hidden" name="order_id" id="order_id" value="">
          <div class="modal-body">
              <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dispatch_qty">Dispatch Qty<span class="requride_cls">*</span>
                  </label>
                  <div class="">
                      <input type="text" id="dispatch_qty" name="dispatch_qty"  class="form-control focusClass numberonly" placeholder="Enter Dispatch Qty" >
                  </div>
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-default remove_validation" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" id="dispatch_submit">Save</button>
          </div>
        </form>
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
        ajax: "{{url('/getOrderData') }}",
        columns: [
          { data: 'DT_RowIndex',searchable: false,orderable: false},
          { data: 'order_no'},
          { data: 'date'},
          { data: 'dealer.name'},
          { data: 'city.name'},
          { data: 'action',orderable: false, searchable: false},
        ],
    });

    /** Close Popup remove validation and value */
    $('.remove_validation').on('click', function () {
      $("#dispatch_qty").val("");
      $("#dispatch_qty-error").remove();
    });

    /** Popup  Modal Validation */
    $('#frm_modal').validate({
      rules:{
        dispatch_qty:{
          required:true,
        },
      },
      messages:
      {
        dispatch_qty:{
          required:"Dispatch Qty Is Required",
        },
      },
      errorPlacement: function(error, element){
        error.insertAfter(element);
      },
      submitHandler: function(form) {
        $(':input[type="submit"]').prop('disabled', true);
        form.submit();
      }
    });

    /** Popup Modal Value Save */
    $('body').on('click','.dispatch-confirm',function(e){
      e.preventDefault();
      var id = $(this).attr("data-id");
      $('#order_id').val(id);
    });

    $('body').on('click','#dispatch_submit',function(e){
      e.preventDefault();
      if($("#frm_modal").valid()){

        var id = $("#order_id").val();
        var dispatch_qty = $("#dispatch_qty").val();

          $.ajax({
            type: "POST",
            url: "{{url('/getDispatchQty')}}",
            data: {dispatch_qty:dispatch_qty, id:id},
            dataType: "json",
            success: function(response){

              $("#dispatch_qty").val("");
              $('#qty_modal').modal('hide');
              $('.datatable').DataTable().ajax.reload();
              swal("success", "Dispatch Qty Insert Successfully !", "success");

            }
          });

        } else {
          return false;
        }

    });

   /** dispatch qty not grater than remaining qty validation*/
    $('body').on('keyup','#dispatch_qty',function(e){
      e.preventDefault();
      var id = $("#order_id").val();
      var dispatch_qty = $("#dispatch_qty").val();

      $.ajax({
        type: "POST",
        url: "{{url('/checkDispatchQty')}}",
        data: {dispatch_qty:dispatch_qty, id:id},
        dataType: "json",
        success: function(data){
          if(data == false){
            swal("warning", "Can not more than Value Remaining Qty !", "warning");
            $("#dispatch_qty").val('');
          }

        }
      });
    });

    /** Onclick Dispatch button  Dispatch all Qty */
    $('body').on('click','.status',function(e){
      e.preventDefault();
      var id = $("#order_id").val();
      var status = $(this).val();

      if(status == 0){
        var msg = "Order Pending!";
      }
      if(status == 1){
        var msg = "Order Partial Dispatch!";
      }
      if(status == 2){
        var msg = "Order Dispatch!";
      }

      $.ajax({
        type: "POST",
        url: "{{url('/statusAll')}}",
        data: {id:id, status:status},
        dataType: "json",
        success: function(data){
          $('.datatable').DataTable().ajax.reload();
          //swal("success", msg, "success");
        }
        });

    });

    /*$(document).on('click', '#dispatch', function(e) {
      e.preventDefault();
      var linkURL = $(this).attr("href");
      swal({
          title: "Are you sure want to Dispatch?",
          text: "As that can be undone by doing reverse.",
          icon: "success",
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              window.location.href = linkURL;
          }
      });
    });*/

});

</script>
@endsection