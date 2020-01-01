@extends('layouts.master')
@section('title')
{{$moduleName}} - {{ Helper::setting()->name }}
@endsection
@section('content')
<!-- page content -->
<div class="right_col" role="main">
	<div class="title_left">
		<a href="{{ url('order') }}"><button class="btn btn-primary" >{{ trans('order.btn.Back') }}</button></a>
	</div>
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>{{ trans('order.view', [ 'module' => $moduleName ]) }}</h2>

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
                                        {{ trans('order.date') }} <span class="requride_cls">*</span>
                                    </label>
                                    <input type="text" id="date" name="date" class="form-control datepicker" readonly value="{{date('d-m-Y', strtotime($order[0]->date))}}">
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <label for="party_id">
                                        {{ trans('order.party_name') }} <span class="requride_cls">*</span>
                                    </label>
                                    <select class="select2_single form-control" name="party_id" id="party_id" disabled>
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
                                        <th>{{ trans('order.tfield.sr_no') }}</th>
                                        <th width="25%">{{ trans('order.product') }} <span class="requride_cls">*</span></th>
                                        <th width="25%">{{ trans('order.price') }} <span class="requride_cls">*</span></th>
                                        <th width="15%">{{ trans('order.qty') }} <span class="requride_cls">*</span></th>
                                        <th width="25%">{{ trans('order.amount') }} <span class="requride_cls">*</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order as $key => $value)
                                    <tr class="ordertable">
                                        <td><label class="sr_no">{{ $key+1 }}</label></td>
                                        <td>
                                            <select id="product_id" name="product_id[]" class="form-control m-bot15 select2_single col-lg-12 product_id" disabled>
                                                <option></option>
                                                @foreach ($product as $key => $val)
                                                    <option value="{{ $val->id }}" {{ ($val->id == $value->product_id) ? 'selected':''  }}>{{ $val->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" id="price" name="price[]" class="form-control" placeholder="{{ trans('order.price') }}"  value={{ $value->price }} readonly>
                                        </td>
                                        <td>
                                            <input type="text" id="qty" name="qty[]" class="form-control numberonly qty" value={{ $value->qty }} placeholder="{{ trans('order.qty') }}" readonly>
                                        </td>
                                        <td>
                                            <input type="text" id="amount" name="amount[]" class="form-control numberonly amount" placeholder="{{ trans('order.amount') }}" value={{ $value->amount }} readonly>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td></td>
                                        <td><label id="product_id_err"></label></td>
                                        <td></td>
                                        <td><label id="qty_err"></label></td>
                                        <td><input type="text" id="total_amount" name="total_amount" class="form-control" placeholder="{{ trans('order.total_amt') }}" readonly></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ trans('order.discount') }} </td>
                                        <td><input type="text" id="discount" name="discount" class="form-control discount" placeholder="{{ trans('order.discount') }}" value="{{ $order[0]->discount }}" readonly></td>
                                    </tr>
                                    <input type="hidden" id="gst_type" name="gst_type" value="{{ (($order[0]->gst_type) == 0) ? '0' : '1' }}">
                                    <tr style="display:{{ (($order[0]->gst_type) == 0) ? '' : 'none' }}">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ trans('order.cgst') }} {{ $order[0]->cgst_per.'%' }} </td>
                                        <td><input type="text" id="cgst" name="cgst" class="form-control" placeholder="{{ trans('order.cgst') }}" readonly value="{{ $order[0]->cgst }}">
                                        <input type="hidden" id="cgst_hidn" name="cgst_hidn" value="{{ $order[0]->cgst_per }}"></td>
                                    </tr>
                                    <tr style="display:{{ (($order[0]->gst_type) == 0) ? '' : 'none' }}">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ trans('order.sgst') }} {{ $order[0]->sgst_per.'%' }} </td>
                                        <td><input type="text" id="sgst" name="sgst" class="form-control" placeholder="{{ trans('order.sgst') }}" readonly value="{{ $order[0]->sgst }}">
                                        <input type="hidden" id="sgst_hidn" name="sgst_hidn" value="{{ $order[0]->sgst_per }}"></td>
                                        </td>
                                    </tr>
                                    <tr style="display:{{ (($order[0]->gst_type) == 1) ? '' : 'none' }}">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ trans('order.igst') }} {{ $order[0]->igst_per.'%' }} </td>
                                        <td><input type="text" id="igst" name="igst" class="form-control" placeholder="{{ trans('order.igst') }}" readonly value="{{ $order[0]->igst }}">
                                        <input type="hidden" id="igst_hidn" name="igst_hidn" value="{{ $order[0]->igst_per }}"></td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ trans('order.grand_total') }}</td>
                                        <td><input type="text" id="grand_total" name="grand_total" class="form-control" placeholder="{{ trans('order.grand_total') }}" value="{{ $order[0]->grand_total }}" readonly></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <hr class="hrClass">

                        <div class="row">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="instruction">
                                    {{ trans('order.instruction') }} <span class="requride_cls">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea id="instruction" name="instruction" class="form-control" placeholder="{{ trans('order.placeholder.instruction') }}" readonly>{{$order[0]->instruction}}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="lr_no">
                                    {{ trans('order.lr_no') }}
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="lr_no" name="lr_no" class="form-control" placeholder="{{ trans('order.placeholder.lr_no') }}" value="{{$order[0]->lr_no}}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="transporter"> {{ trans('order.transporter') }}
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="transporter" name="transporter" class="form-control" placeholder="{{ trans('order.placeholder.transporter') }}" value="{{$order[0]->transporter}}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <a href=" {{ url('order') }}" class="btn btn-primary">{{ trans('order.btn.Cancel') }}</a>
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
