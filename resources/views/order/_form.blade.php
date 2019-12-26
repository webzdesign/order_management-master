@extends('layouts.master')
@section('title')
{{$moduleName}} - {{ Helper::setting()->name }}
@endsection
@section('content')
<!-- page content -->
<div class="right_col" role="main">
	<div class="title_left">
		<a href="{{ url('order') }}"><button class="btn btn-primary" >Back</button></a>
	</div>
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Edit {{$moduleName}}</h2>

					<div class="clearfix"></div>
				</div>
				<div class="x_content">
                    <form id="frm" method="post"  action ="{{route('order.update', $order[0]->order_id)}}"  class="form-horizontal form-label-left" autocomplete="off" enctype="multipart/form-data">
						@method('PUT')
						<input type="hidden" id="id" name="id" value="{{ $order[0]->order_id }}" />
                        @csrf

                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <label for="date">
                                        Date <span class="requride_cls">*</span>
                                    </label>
                                    <input type="text" id="date" name="date" class="form-control datepicker" readonly value="{{date('d-m-Y', strtotime($order[0]->date))}}">
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <label for="party_id">
                                        Party Name <span class="requride_cls">*</span>
                                    </label>
                                    <select class="select2_single form-control" name="party_id" id="party_id">
                                        <option value=""></option>
                                        @foreach($party as $key => $val)
                                            <option value="{{ $val->id }}" {{ ($val->id == $order[0]->party_id)? 'selected':'' }}>{{ $val->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <hr class="hrClass">

                        <div class="row">
                            <table id="order" class="table table-bordered" cellspacing="0">
                                <thead>
                                    <tr class="success">
                                        <th>SrNo</th>
                                        <th width="25%">Product <span class="requride_cls">*</span></th>
                                        <th width="25%">Price <span class="requride_cls">*</span></th>
                                        <th width="15%">Qty <span class="requride_cls">*</span></th>
                                        <th width="25%">Amount <span class="requride_cls">*</span></th>
                                        <th width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order as $key => $value)
                                    <tr class="ordertable">
                                        <td><label class="sr_no">{{ $key+1 }}</label></td>
                                        <td>
                                            <select id="product_id" name="product_id[]" class="form-control m-bot15 select2_single col-lg-12 product_id">
                                                <option></option>
                                                @foreach ($product as $key => $val)
                                                    <option value="{{ $val->id }}" {{ ($val->id == $value->product_id) ? 'selected':''  }}>{{ $val->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" id="price" name="price[]" class="form-control" placeholder="Price"  value={{ $value->price }} readonly>
                                        </td>
                                        <td>
                                            <input type="text" id="qty" name="qty[]" class="form-control numberonly qty" value={{ $value->qty }} placeholder="Qty">
                                        </td>
                                        <td>
                                            <input type="text" id="amount" name="amount[]" class="form-control numberonly amount" placeholder="Amount" value={{ $value->amount }} readonly>
                                        </td>
                                        <td>
                                            <button  tabindex="1" type="button" class="btn btn-success add btn-xs " onclick="">+</button>
                                            <button tabindex="1" type="button" class="btn btn-danger minus btn-xs">-</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td></td>
                                        <td><label id="product_id_err"></label></td>
                                        <td></td>
                                        <td><label id="qty_err"></label></td>
                                        <td><input type="text" id="total_amount" name="total_amount" class="form-control" placeholder="Total Amount" readonly></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Discount </td>
                                        <td><input type="text" id="discount" name="discount" class="form-control discount" placeholder="Discount" value="{{ $order[0]->discount }}"></td>
                                        <td></td>
                                    </tr>
                                    <input type="hidden" id="gst_type" name="gst_type" value="{{ (($order[0]->gst_type) == 0) ? '0' : '1' }}">
                                    <tr style="display:{{ (($order[0]->gst_type) == 0) ? '' : 'none' }}">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>CGST {{ $order[0]->cgst_per.'%' }} </td>
                                        <td><input type="text" id="cgst" name="cgst" class="form-control" placeholder="CGST" readonly value="{{ $order[0]->cgst }}">
                                        <input type="hidden" id="cgst_hidn" name="cgst_hidn" value="{{ $order[0]->cgst_per }}"></td>
                                        <td></td>
                                    </tr>
                                    <tr style="display:{{ (($order[0]->gst_type) == 0) ? '' : 'none' }}">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>SGST {{ $order[0]->sgst_per.'%' }} </td>
                                        <td><input type="text" id="sgst" name="sgst" class="form-control" placeholder="SGST" readonly value="{{ $order[0]->sgst }}">
                                        <input type="hidden" id="sgst_hidn" name="sgst_hidn" value="{{ $order[0]->sgst_per }}"></td>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr style="display:{{ (($order[0]->gst_type) == 1) ? '' : 'none' }}">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>IGST {{ $order[0]->igst_per.'%' }} </td>
                                        <td><input type="text" id="igst" name="igst" class="form-control" placeholder="IGST" readonly value="{{ $order[0]->igst }}">
                                        <input type="hidden" id="igst_hidn" name="igst_hidn" value="{{ $order[0]->igst_per }}"></td>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Grand Total </td>
                                        <td><input type="text" id="grand_total" name="grand_total" class="form-control" placeholder="Grand Total" value="{{ $order[0]->grand_total }}" readonly></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <hr class="hrClass">

                        <div class="row">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="instruction">
                                    Instruction <span class="requride_cls">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea id="instruction" name="instruction" class="form-control" placeholder="Enter Instruction">{{$order[0]->instruction}}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="lr_no">
                                    LR No
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="lr_no" name="lr_no" class="form-control" placeholder="Enter LR No" value="{{$order[0]->lr_no}}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="transporter"> Transporter
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="transporter" name="transporter" class="form-control" placeholder="Enter Transporter" value="{{$order[0]->transporter}}">
                                </div>
                            </div>
                        </div>

                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <a href=" {{ url('order') }}" class="btn btn-primary">Cancel</a>
                                <button type="submit" class="btn btn-success" id="submitButton">Submit</button>
                            </div>
                        </div>
                    </form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /page content -->
@endsection
@section('script')
<script>
$(document).ready(function(){

    function sr_change(){
        var count= $('.ordertable').length;
        for(var i=0; i< count; i++){
            var cnt = i+1;
            $("label.sr_no").eq(i).text(cnt);
        }
    }

    $('body').on('click',".add",function(){
        var $tr = $(this).closest('.ordertable');
        var $clone = $tr.clone();

        $clone.find(".product_id").select2({
            placeholder: "Select ",
            allowClear: true,
            width: '100%'
        });

        $clone.find('input').val('');
        $clone.find('span:nth-child(3)').remove();

        $tr.after($clone);
        $clone.find('select').val('').trigger('change');
        sr_change();
        total();
    });

    $('body').on('click','.minus' ,function(event){
        if($(".ordertable").length > 1){
            $(this).closest(".ordertable").remove();
            sr_change();
            total();
        }
    });

    $('#frm').validate({
        rules:{
            date:{ required:true, },
            party_id:{ required:true, },
            instruction:{ required:true, },
        },
        messages:
        {
            date:{ required:"Date Is Required.", },
            party_id:{ required:"Party Name Is Required.", },
            instruction:{ required:"Instruction Is Required.", },
        },
        errorPlacement: function(error, element) {
            error.appendTo(element.parent("div"));
        },
    });

    function validationCheck() {
        var productCheck = [];
        var qtyCheck = [];
        var errorStatus = 0;

        $('.product_id').each(function () {
            if ($(this).val() == '' ) {
                productCheck.push(0);
            } else  {
                productCheck.push(1);
            }
        });

        $('.qty').each(function () {
            if ($(this).val() == '' ) {
                qtyCheck.push(0);
            } else  {
                qtyCheck.push(1);
            }
        });

        var product_err = productCheck.indexOf(0);
        var qty_err = qtyCheck.indexOf(0);

        if (product_err != '-1') {
            var str = "Product Is Required";
            var result = str.fontcolor("red");
            document.getElementById('product_id_err').innerHTML = result;
            errorStatus = 1;
        } else {
            document.getElementById('product_id_err').innerHTML = '';
        }

        if (qty_err != '-1') {
            var str = "Qty Is Required";
            var result = str.fontcolor("red");
            document.getElementById('qty_err').innerHTML = result;
            errorStatus = 1;
        } else {
            document.getElementById('qty_err').innerHTML = '';
        }
        return errorStatus;
    }

    function total()
    {
        var grandTotal = 0;
        $('.qty').each(function () {
            var qty = $(this).val();
            if (isNaN(qty) || qty == '') {
                qty = 0
            }
            var price = $(this).closest('tr').find('#price').val();
            if (isNaN(price) || price == '') {
                price = 0
            }
            var amount = price*qty;
            grandTotal = grandTotal+amount;
            $(this).closest('tr').find('#amount').val(amount.toFixed(2));

        });

        var discount = $('body').find('#discount').val();
        if (isNaN(discount) || discount == '') {
            discount = 0
        }

        var totalAmount = parseFloat(grandTotal) - parseFloat(discount);
        $('body').find('#total_amount').val(grandTotal.toFixed(2));

        var cgstPer = $('#cgst_hidn').val();
        var sgstPer = $('#sgst_hidn').val();
        var igstPer = $('#igst_hidn').val();
        var gst_type = $('#gst_type').val();

        var cgst = (cgstPer / 100) * parseFloat(totalAmount);
        var sgst = (sgstPer / 100) * parseFloat(totalAmount);
        var igst = (igstPer / 100) * parseFloat(totalAmount);

        $('body').find('#cgst').val(cgst.toFixed(2));
        $('body').find('#sgst').val(sgst.toFixed(2));
        $('body').find('#igst').val(igst.toFixed(2));

        var gstwithAmount = parseFloat(cgst) + parseFloat(sgst) + parseFloat(totalAmount);
        var igstwithAmount = parseFloat(igst) + parseFloat(totalAmount);

        if(gst_type == 0) {
            $('body').find('#grand_total').val(gstwithAmount.toFixed(2));
        } else {
            $('body').find('#grand_total').val(igstwithAmount.toFixed(2));
        }
    }
    total();

    $(document).on('change', '.product_id' ,function(){
        product_id = $(this).val();
        var th = $(this);
        $.ajax({
            url: "{{url('/getProductPrice')}}",
            type: "POST",
            dataType:'json',
            data: {product_id : product_id},
            success:function(data){
                th.closest('tr').find('#price').val(data);
            },
        });
        total();
    });

    $(document).on('keyup', '.qty, .discount' ,function(){
        total();
    });

    $("body").on("click","#submitButton",function(e){
        e.preventDefault();
        validationCheck();
        if ($("#frm").valid()) {
            var status = validationCheck();
            if (status == 0) {
                $(':input[type="submit"]').prop('disabled', true);
                $("#frm").submit();
            } else {
                return false;
            }
        } else {
            return false;
        }
    });

});
</script>
@endsection
