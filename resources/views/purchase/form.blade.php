@extends('layouts.master')
@section('title')
{{ trans('stockpurchase.detail', [ 'module' => $moduleName ]).' - '.Helper::setting()->name  }}
@endsection
  @section('content')
  <!-- page content -->
  <div class="right_col" role="main">
    <div class="">
      <div class="title_left">
        <a href="{{url('purchase')}}"><button class="btn btn-primary" >{{ trans('stockpurchase.btn.Back') }}</button></a>
      </div>
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>{{ trans('stockpurchase.add', [ 'module' => $moduleName ]) }}</h2>

              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <form id="frm" method="post"  action ="{{route('purchase.store')}}"  class="form-horizontal form-label-left" autocomplete="off" enctype="multipart/form-data">
                @csrf


                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="date">{{ trans('stockpurchase.date') }}<span class="requride_cls">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="date" name="date"  class="form-control col-md-7 col-xs-12 focusClass datepicker " placeholder="{{ trans('stockpurchase.placeholder.select_date') }}" value="{{ date('d-m-Y')}}" readonly>
                  </div>
                </div>

                
                <div class="row">
                  <div>
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="purchase">{{ trans('stockpurchase.purchase_detail') }}<span class="requride_cls">*</span>
                    </label>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <table id="recipe" class="table table-bordered" cellspacing="0">
                      <thead>
                        <tr class="success">
                          <th>{{ trans('stockpurchase.tfield.sr_no') }}</th>
                          <th width="50%">{{ trans('stockpurchase.tfield.product') }} <span class="requride_cls">*</span></th>
                          <th width="30%">{{ trans('stockpurchase.tfield.qty') }} <span class="requride_cls">*</span></th>
                          <th>{{ trans('stockpurchase.tfield.action') }} </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr class="purchasetable">
                          <td><label class="sr_no">1 </label></td>
                          <td>
                              <select id="product_id" name="product_id[]" class="select2" style="width:100%;">
                                  @foreach ($products as $key => $val)
                                    <option value="{{ $val->id }}">{{ $val->name }}</option>
                                  @endforeach
                              </select>
                          </td>
                          <td>
                              <input type="text" id="qty" name="qty[]" class="form-control numberonly qty" placeholder="{{ trans('stockpurchase.placeholder.qty') }}">
                          </td>
                          <td>
                              <button  tabindex="1" type="button" class="btn btn-success add btn-xs " onclick="">+</button>
                              <button tabindex="1" type="button" class="btn btn-danger minus btn-xs">-</button>
                          </td>
                        </tr>
                        <tr>
                          <td></td>
                          <td><label id="product_id_err"></label></td>
                          <td><label id="qty_err"></label></td>
                          <td></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>

                <div class="ln_solid col-md-12 col-sm-12 col-xs-12"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href=" {{ url('purchase') }}" class="btn btn-primary">{{ trans('stockpurchase.btn.Cancel') }}</a>
                    <button type="submit" class="btn btn-success focusClass" id="submitButton">{{ trans('stockpurchase.btn.Submit') }}</button>
                  </div>
                </div>

              </form>
            </div>
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
      
      $(".select2").select2({
            placeholder: "Select",
            allowClear: true,
            width:'100%'
      });

      function sr_change(){
      var count= $('.purchasetable').length;
      for(var i=0; i< count; i++){
        var cnt = i+1;
        $("label.sr_no").eq(i).text(cnt);
        }
      }

      $('body').on('change', '.product_id', function(){
          validationCheck();
      })

      $('body').on('keyup', '.qty', function(){
          validationCheck();
      })

      $('body').on('click',".add", function(){
        var $tr = $(this).closest('.purchasetable');
        var $clone = $tr.clone();

        $clone.find(".select2").select2({
            placeholder: "Select"
        });

        $clone.find('.select2').val('').trigger('change');
        $clone.find('span:nth-child(3)').remove();
        $clone.find('input').val('');

         $tr.after($clone);
         sr_change();

      });

      $('body').on('click','.minus' ,function(event){
        if($(".purchasetable").length > 1){
            $(this).closest(".purchasetable").remove();
            sr_change();
        }
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
						var str = "{{ trans('stockpurchase.message.product_err') }}";
						var result = str.fontcolor("red");
						document.getElementById('product_id_err').innerHTML = result;
						errorStatus = 1;
				} else {
						document.getElementById('product_id_err').innerHTML = '';
				}

				if (qty_err != '-1') {
						var str = "{{ trans('stockpurchase.message.qty_err') }}";
						var result = str.fontcolor("red");
						document.getElementById('qty_err').innerHTML = result;
						errorStatus = 1;
				} else {
						document.getElementById('qty_err').innerHTML = '';
				}

				return errorStatus;
      }
      
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
