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
                    <h2>{{ trans('order.add', [ 'module' => $moduleName ]) }}</h2>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form id="frm" method="post"  action ="{{ route('order.store') }}"  class="form-horizontal form-label-left" autocomplete="off" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <label for="date">
                                        {{ trans('order.date') }}  <span class="requride_cls">*</span>
                                    </label>
                                    <input type="text" id="date" name="date" class="form-control datepicker" readonly value="{{ date('d-m-Y') }}">
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <label for="party_id">
                                        {{ trans('order.party_name') }} <span class="requride_cls">*</span>
                                    </label>
                                    <select class="select2" name="party_id" id="party_id" style="width:100%;">
                                        <option value=""></option>
                                        @foreach($party as $key => $val)
                                            <option value="{{ $val->id }}">{{ $val->name }}</option>
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
                                        {{--  <th>{{ trans('order.tfield.sr_no') }}</th>  --}}
                                        <th width="25%">{{ trans('order.product') }} <span class="requride_cls">*</span></th>
                                        <th width="25%">{{ trans('order.price') }} <span class="requride_cls">*</span></th>
                                        <th width="15%">{{ trans('order.qty') }} <span class="requride_cls">*</span></th>
                                        <th width="25%">{{ trans('order.amount') }} <span class="requride_cls">*</span></th>
                                        <th width="10%">{{ trans('order.tfield.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="addrow">
                                    <tr class="ordertable">
                                        <td>
                                            <select id="product_id" name="product_id[]" class=" select2 product_id" style="width:100%;">
                                                <option></option>
                                                @foreach ($product as $key => $val)
                                                    <option value="{{ $val->id }}">{{ $val->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" id="price" name="price[]" class="form-control" placeholder="{{ trans('order.price') }}" readonly>
                                        </td>
                                        <td><input type="text" id="qty" name="qty[]" class="form-control numberonly qty" placeholder="{{ trans('order.qty') }}"></td>
                                        <td>
                                            <input type="text" id="amount" name="amount[]" class="form-control numberonly amount" placeholder="{{ trans('order.amount') }}" readonly>
                                        </td>
                                        <td>
                                            <button type="button" name="add[]" class="btn btn-success add btn-xs ">+</button>
                                            <button type="button" name="minus[]" class="btn btn-danger minus btn-xs">-</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        {{--  <td></td>  --}}
                                        <td><label id="product_id_err"></label></td>
                                        <td></td>
                                        <td><label id="qty_err"></label></td>
                                        <td><input type="text" id="total_amount" name="total_amount" class="form-control" placeholder="{{ trans('order.total_amt') }}" readonly></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        {{--  <td></td>  --}}
                                        <td></td>
                                        <td></td>
                                        <td>{{ trans('order.discount') }}</td>
                                        <td><input type="text" id="discount" name="discount" class="form-control discount" placeholder="{{ trans('order.discount') }}" value="0"></td>
                                        <td></td>
                                    </tr>
                                    <input type="hidden" id="gst_type" name="gst_type" value="{{ ((Helper::setting()->gst_type) == 0) ? '0' : '1' }}">
                                    <tr style="display:{{ ((Helper::setting()->gst_type) == 0) ? '' : 'none' }}">
                                        {{--  <td></td>  --}}
                                        <td></td>
                                        <td></td>
                                        <input type="hidden" name="cgst_per" id="cgst_per" value="{{ Helper::setting()->cgst }}">
                                        <td>{{ trans('order.cgst') }} {{ Helper::setting()->cgst.'%' }} </td>
                                        <td><input type="text" id="cgst" name="cgst" class="form-control" placeholder="{{ trans('order.cgst') }}" readonly value="">
                                        <input type="hidden" id="cgst_hidn" name="cgst_hidn" value="{{ Helper::setting()->cgst }}"></td>
                                        <td></td>
                                    </tr>
                                    <tr style="display:{{ ((Helper::setting()->gst_type) == 0) ? '' : 'none' }}">
                                        {{--  <td></td>  --}}
                                        <td></td>
                                        <td></td>
                                        <input type="hidden" name="sgst_per" id="sgst_per" value="{{ Helper::setting()->sgst }}">
                                        <td>{{ trans('order.sgst') }} {{ Helper::setting()->sgst.'%' }} </td>
                                        <td><input type="text" id="sgst" name="sgst" class="form-control" placeholder="{{ trans('order.sgst') }}" readonly value="">
                                        <input type="hidden" id="sgst_hidn" name="sgst_hidn" value="{{ Helper::setting()->sgst }}"></td>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr style="display:{{ ((Helper::setting()->gst_type) == 1) ? '' : 'none' }}">
                                        {{--  <td></td>  --}}
                                        <td></td>
                                        <td></td>
                                        <input type="hidden" name="igst_per" id="igst_per" value="{{ Helper::setting()->igst }}">
                                        <td>{{ trans('order.igst') }} {{ Helper::setting()->igst.'%' }} </td>
                                        <td><input type="text" id="igst" name="igst" class="form-control" placeholder="{{ trans('order.igst') }}" readonly value="">
                                        <input type="hidden" id="igst_hidn" name="igst_hidn" value="{{ Helper::setting()->igst }}"></td>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        {{--  <td></td>  --}}
                                        <td></td>
                                        <td></td>
                                        <td>{{ trans('order.grand_total') }} </td>
                                        <td><input type="text" id="grand_total" name="grand_total" class="form-control" placeholder="{{ trans('order.grand_total') }}" value="" readonly></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <hr class="hrClass">

                        <div class="row">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="instruction">
                                    {{ trans('order.instruction') }} <span class="requride_cls">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea id="instruction" name="instruction" class="form-control instruction" placeholder="{{ trans('order.placeholder.instruction') }} "></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="lr_no">
                                    {{ trans('order.lr_no') }}
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="lr_no" name="lr_no" class="form-control lr_no" placeholder="{{ trans('order.placeholder.lr_no') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="transporter"> {{ trans('order.transporter') }}
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="transporter" name="transporter" class="form-control transporter" placeholder="{{ trans('order.placeholder.transporter') }}">
                                </div>
                            </div>
                        </div>

                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <a href=" {{ url('order') }}" class="btn btn-primary">{{ trans('order.btn.Cancel') }}</a>
                                <button type="submit" class="btn btn-success" id="submitButton">{{ trans('order.btn.Submit') }}</button>
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
    function renumber()
    {
        var cnt=$('.ordertable').length;
        var c=0;
        //console.log(cnt);
        if(c<cnt)
        {
            c=0
            $('.add').each(function(){
                $(this).attr('name','add['+c+']')
                c++
            });
            c=0
            $('.minus').each(function(){
                $(this).attr('name','minus['+c+']')
                c++
            });
        }
    }

$(document).ready(function(){

    _.templateSettings.variable = "element";
	var tpl = _.template($("#form_tpl").html());
	var counter = 1;
	var $add_focus = 0;

	$("body").on('keydown','.add',function(e){
		e.preventDefault();
		var key_code = e.which || e.keyCode;
		var $currentTarget = e.currentTarget;
		var $tr = $($currentTarget).closest("tr");
		var $trRowIndex = $tr.index();
		e.preventDefault();
		if(key_code == 32)
		{
			var tplData = {
				i: counter
			};
			$cl=$(this).closest("tr").after(tpl(tplData));
			counter += 1;
			$(".select2").select2("destroy");
			$(".select2").select2({
				placeholder: "Select",
				allowClear:true,
			});
			renumber();
			total();

			var $selectTag = $("table tbody#addrow tr:eq("+($trRowIndex+1)+") td:eq(0)").find("select");
			$($selectTag).select2("focus");
		}
		else if(key_code == 13)
		{
			var $buttonTag = $("table tbody#addrow tr:eq("+$trRowIndex+") td:eq(4)").find(".minus");
			$($buttonTag).focus();
		}
		else if(key_code == 9) {
			if(e.shiftKey) {
				var $inputID = $("table tbody#addrow tr:eq("+$trRowIndex+") td:eq(2)").find("input");
				$inputID.focus();
			}
			else{
				var $buttonTag = $("table tbody#addrow tr:eq("+$trRowIndex+") td:eq(4)").find(".minus");
				$($buttonTag).focus();
			}
		}
		return false;
	});

	$('body').on('keydown',".minus",function(e){
		var key_code = e.which || e.keyCode;
		var $currentTarget = e.currentTarget;
		var $tr = $($currentTarget).closest("tr");
		var $trRowIndex = $tr.index();
		e.preventDefault();
		var count= $('.ordertable').length;
		var value=count-1;
		if(key_code == 32)
		{
			if(value>=1){
				$(this).closest('.ordertable').fadeOut('fast', function(){
					$(this).closest('.ordertable').remove();
					total();
					var $selectTag = $("table tbody#addrow tr:eq("+($trRowIndex-1)+") td:eq(0)").find("select");
					$($selectTag).select2("focus");
				});
			}
			renumber();
		}
		else if(key_code == 13)
		{
            var $trCount = $("table tbody#addrow tr").length-1;
			if(($trCount - 1) - $trRowIndex == 0){
               // $("button[type=submit]").focus();
                $('#instruction').focus();
			}else{
				var $selectTag = $("table tbody#addrow tr:eq("+($trRowIndex+1)+") td:eq(0)").find("select");
				$($selectTag).select2("focus");
			}
		}
		else if(key_code == 9) {
			if(e.shiftKey) {
                var $buttonTag = $("table tbody#addrow tr:eq("+$trRowIndex+") td:eq(4)").find(".add");
				$($buttonTag).focus();
			}
			else{
				$("button[type=submit]").focus();
			}
		}
	});


    /*function sr_change(){
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
        sr_change();
        total();
    });

    $('body').on('click','.minus' ,function(event){
        if($(".ordertable").length > 1){
            $(this).closest(".ordertable").remove();
            sr_change();
            total();
        }
    }); */

    $('#frm').validate({
    ignore: ".select2-input",
        rules:{
            date:{ required:true, },
            party_id:{ required:true, },
            instruction:{ required:true, },
        },
        messages:
        {
            date:{ required:"{{ trans('order.message.date') }}", },
            party_id:{ required:"{{ trans('order.message.party_name') }}", },
            instruction:{ required:"{{ trans('order.message.instruction') }}", },
        },
        errorPlacement: function(error, element) {
            error.appendTo(element.parent("div"));
        },
    });

    function validationCheck() {
        var productCheck = [];
        var qtyCheck = [];
        var errorStatus = 0;

        $('select.product_id').each(function () {
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
            var str = "{{ trans('order.message.product') }}";
            var result = str.fontcolor("red");
            document.getElementById('product_id_err').innerHTML = result;
            errorStatus = 1;
        } else {
            document.getElementById('product_id_err').innerHTML = '';
        }

        if (qty_err != '-1') {
            var str = "{{ trans('order.message.qty') }}";
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

    <!-- On Enter Key Start -->

    $(".select2").select2({
		placeholder: "Select",
		allowClear: true
	});

	$("body").on("select2-selecting", "#party_id", function(event){
		var $th = $(this);
		var $currentTarget = event.currentTarget;
		var $tr = $($currentTarget).closest("tr");
		var $trRowIndex = $tr.index();
		var $selectTag = $("table tbody#addrow tr:eq(0) td:eq(0)").find("select");
		setTimeout(function() {
				$($selectTag).select2("focus");
			}, 0);
    });

    $("body").on("keydown", ".select2", function(e) {
		var $currentTarget = e.currentTarget;
		var key_code = e.which || e.keyCode;
		if($($currentTarget).attr("id") == "s2id_party_id"){
			if(key_code == 9) {
				if(e.shiftKey) {
					$("button[type=submit]").focus();
					e.preventDefault();
				}
			}
			else if(key_code == 13){
				var $selectTag = $("table tbody#addrow tr:eq(0) td:eq(0)").find("select");
				setTimeout(function() {
					$($selectTag).select2("focus");
				}, 0);
			}
		}
    });

    $("body").on("select2-selecting", ".product_id", function(event){
		var $currentTarget = event.currentTarget;
		var $tr = $($currentTarget).closest("tr");
        var $trRowIndex = $tr.index();
        var $inputID = $("table tbody#addrow tr:eq("+$trRowIndex+") td:eq(0)").find("input");
        var $inputIDqty = $(".qty");
        setTimeout(function() {
            $($inputIDqty).focus();
        }, 0);
    });

    $("body").on("keydown", ".qty", function(event){
        var $currentTarget = event.currentTarget;
        var $tr = $($currentTarget).closest("tr");
        var $trRowIndex = $tr.index();
        var key_code = event.which || event.keyCode;
        var $buttonTag = $("table tbody#addrow tr:eq("+$trRowIndex+") td:eq(4)").find(".add");
        var $prevID = $("table tbody#addrow tr:eq("+$trRowIndex+") td:eq(2)").find("input");

        if(key_code == 13){
            $($buttonTag).focus();
            event.preventDefault();
        }else if(key_code == 9) {
            if(event.shiftKey){
                $($prevID).focus();
                event.preventDefault();
            }else{
                $($buttonTag).focus();
                event.preventDefault();
            }
        }
    });

    $("body").on("keydown", ".instruction", function(event){
        var $currentTarget = event.currentTarget;
        var $tr = $($currentTarget).closest("tr");
        var $trRowIndex = $tr.index();
        var key_code = event.which || event.keyCode;
        var $lrnoId = $(".lr_no");

        if(key_code == 13){
            $($lrnoId).focus();
            event.preventDefault();
        }
    });

    $("body").on("keydown", ".lr_no", function(event){
        var $currentTarget = event.currentTarget;
        var $tr = $($currentTarget).closest("tr");
        var $trRowIndex = $tr.index();
        var key_code = event.which || event.keyCode;
        var $transId = $(".transporter");

        if(key_code == 13){
            $($transId).focus();
            event.preventDefault();
        }
    });

    $("body").on("keydown", ".transporter", function(event){
        var $currentTarget = event.currentTarget;
        var $tr = $($currentTarget).closest("tr");
        var $trRowIndex = $tr.index();
        var key_code = event.which || event.keyCode;

        if(key_code == 13){
            $("button[type=submit]").focus();
            event.preventDefault();
        }

    });

    $("body").on("keydown", "button[type=submit]", function(event){
        var keyCode = event.keyCode || event.which;
        var $th = $(this);
        var $tr_length = $("table tbody#addrow tr").length-1;
        var $prevID = $("table tbody#addrow tr:eq("+$tr_length+") td:eq(4)").find(".minus");

        if(keyCode == 13) {
            $("#party_id").select2('focus');
            event.preventDefault();
        }
        else if(keyCode == 9) {
            if(event.shiftKey) {
            }else{
                $("#party_id").select2('focus');
                event.preventDefault();
            }
        }else if(keyCode == 32)
        {
            $th.trigger("click");
        }
    });

    $("body").on("click", ".add, .minus", function(e){
		var $th = $(this);
		var $currentTarget = e.currentTarget;
		var $tr = $($currentTarget).closest("tr");
		var $trRowIndex = $tr.index();
		e.preventDefault();
		if($th.hasClass("minus"))
		{
			var count= $('.ordertable').length;
			var value=count-1;
			if(value>=1){
				$(this).closest('.ordertable').fadeOut('fast', function(){
					$(this).closest('.ordertable').remove();
                    total();
					var $selectTag = $("table tbody#addrow tr:eq("+($trRowIndex-1)+") td:eq(0)").find("select");
					$($selectTag).select2("focus");
				});
			}
			renumber();
		}else if($th.hasClass("add")){
			var tplData = {
				i: counter
			};
			$cl=$(this).closest("tr").after(tpl(tplData));
			counter += 1;
			$(".select2").select2("destroy");
			$(".select2").select2({
				placeholder: "Select",
				allowClear:true,
			});
			renumber();
            total();

			var $selectTag = $("table tbody#addrow tr:eq("+($trRowIndex+1)+") td:eq(0)").find("select");
			$($selectTag).select2("focus");
		}else{}
	});

    $("#party_id").select2('focus');
});
</script>
<script  type="text/html" id="form_tpl">
    <tr class="ordertable">
        <td>
            <select id="product_id" name="product_id[]" class="select2 product_id" style="width:100%;">
                <option></option>
                @foreach ($product as $key => $val)
                    <option value="{{ $val->id }}">{{ $val->name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="text" id="price" name="price[]" class="form-control" placeholder="{{ trans('order.price') }}" readonly>
        </td>
        <td>
            <input type="text" id="qty" name="qty[]" class="form-control numberonly qty" placeholder="{{ trans('order.qty') }}">
        </td>
        <td>
            <input type="text" id="amount" name="amount[]" class="form-control numberonly amount" placeholder="{{ trans('order.amount') }}" readonly>
        </td>
        <td>
            <button type="button" name="add[]" class="btn btn-success add btn-xs " onclick="">+</button>
            <button type="button" name="minus[]" class="btn btn-danger minus btn-xs">-</button>
        </td>
    </tr>
</script>
@endsection
