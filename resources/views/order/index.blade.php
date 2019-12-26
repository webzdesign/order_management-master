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
                    <h2>{{$moduleName }} Details</h2>
                    <div>
                        @permission('create.order')
                            <a href="{{ route('order.create') }}"><button class="btn btn-primary" style="float:right;"><i class="fa fa-plus"></i> New</button></a>
                        @endpermission
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box table-responsive">
                                <table class="datatable mdl-data-table dataTable table table-striped table-bordered" cellspacing="0" width="100%" role="grid" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>SrNo</th>
                                            <th>OrderNo</th>
                                            <th>Date</th>
                                            <th>Party Name</th>
											<th>Grand Total</th>
                                            <th>Status</th>
                                            <th>Added By</th>
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

 <!-- Dispatch qty Popup modal start -->
<div class="modal fade bs-example-modal-sm" id="dispatchModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">Dispatch Qty</h4>
            </div>
            <div class="modal-body" >
                <form class="form-horizontal" id="frm_modal" method="post" autocomplete="off">
                    @csrf
                    <input type="hidden" name="order_id" id="order_id">
                    <div class="modal-body">
                        <div class="form-group table-responsive">
                            <table id="order" class="table table-bordered" cellspacing="0">
                                <thead>
                                    <tr class="success">
                                        <th width="5%">SrNo</th>
                                        <th width="30%">Product <span class="requride_cls">*</span></th>
                                        <th width="25%">Remaining Qty <span class="requride_cls">*</span></th>
                                        <th width="25%">Dispatch Qty</th>
                                    </tr>
                                </thead>
                                <tbody class="tableBody" id="ExistOrderData">

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><label id="dispatch_qty_err"></label></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="dispatch_submit">Save</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<!-- Dispatch qty Popup modal End -->
@endsection
@section('script')
<script>
$(document).ready(function() {

    @if (Session::has('message'))
    new PNotify({
        title: '{{ $moduleName }}',
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
        ajax: "{{url('getOrderData') }}",
        columns: [
          { data: 'DT_RowIndex',searchable: false,orderable: false},
          { data: 'order_no'},
		  { data: 'date'},
		  { data: 'party.name'},
		  { data: 'grand_total'},
          { data: 'status'},
          { data: 'user.name'},
          { data: 'action',orderable: false, searchable: false},
        ],
    });


    /** Popup  Modal Validation */
    /*$('#frm_modal').validate({
        rules:{
            'dispatch_qty[]':{
            required:true,
            },
        },
        messages:
        {
            'dispatch_qty[]':{
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
    });*/

    /** dispatch qty not grater than remaining qty validation*/
    $('body').on('keyup','.dispatch_qty',function(e){
        e.preventDefault();
        var disQty = $(this).val();
        var remQty = $(this).closest('tr').find('#remaining_qty').val();

        if (parseFloat(disQty) > parseFloat(remQty)) {
            $(this).val('');
        }
    });

    /** Popup Modal Value Save */
    $('body').on('click','.dispatch-confirm',function(e){
        e.preventDefault();
        var order_id = $(this).attr("data-id");
        $('body').find('#order_id').val(order_id);
        $("#dispatch_qty-error").remove();
        $.ajax({
            type: "POST",
            url: "{{url('getExistOrderDetail')}}",
            data: {order_id:order_id},
            success: function(res){
                if (res != '') {
                    $('#dispatchModal').find('#ExistOrderData').empty().html(res);
                    $('#tables,.item_id').select2({
                        placeholder: "Select",
                        allowClear: true,
                        width: '100%'
                    });
                }
            }
        });
    });

    $('body').on('click','#dispatch_submit',function(e){
        e.preventDefault();
        if($("#frm_modal").valid()){
            var th = $(this);
            var id = $("#order_id").val();
            var dispatchQty = [];
            var remainingProduct = [];

            $('.dispatch_qty').each(function () {
                if ($(this).val() != '' ) {
                    var index = $(this).closest('tr').find("#orderId").val();
                    dispatchQty[index] = $(this).val();
                }
            });

            $('.remaining_product').each(function () {
                if ($(this).val() != '' ) {
                    remainingProduct.push($(this).val());
                }
            });

            $.ajax({
                type: "POST",
                url: "{{url('/getDispatchQty')}}",
                data: {dispatchQty:dispatchQty, id:id, remainingProduct:remainingProduct},
                dataType: "json",
                success: function(response){

                    $("#dispatch_qty").val("");
                    $('#dispatchModal').modal('hide');
                    $('.datatable').DataTable().ajax.reload();
                    swal("success", "Dispatch Qty Insert Successfully !", "success");
                }
            });
        } else {
        return false;
        }
    });

});

</script>
@endsection
