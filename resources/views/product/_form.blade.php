@extends('layouts.master')
@section('title')
{{$moduleName}} - {{ Helper::setting()->name }}
@endsection
@section('content')
<!-- page content -->
<div class="right_col" role="main">
	<div class="title_left">
		<a href="{{ url('product') }}"><button class="btn btn-primary" >{{ trans('product.btn.Back') }}</button></a>
	</div>
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>{{ trans('product.edit', [ 'module' => $moduleName ]) }}</h2>

					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<form id="frm" method="post"  action ="{{route('product.update', $product->id)}}"  class="form-horizontal form-label-left" autocomplete="off" enctype="multipart/form-data">
						@method('PUT')
						<input type="hidden" id="id" name="id" value="{{ $product->id }}" />
                        @csrf

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_id">
                                {{ trans('product.cat_name') }} <span class="requride_cls">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select class="select2 changefocus" name="category_id" id="category_id">
                                    <option value=""></option>
                                    @foreach($category as $key => $val)
                                        <option {{ ($val->id == $product->category_id) ? 'selected' : '' }} value="{{ $val->id }}">{{ $val->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
								{{ trans('product.product_name') }}<span class="requride_cls">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="name" name="name" class="form-control col-md-7 col-xs-12 focusClass changefocus" placeholder="{{ trans('product.placeholder.product_name') }}" value="{{ $product->name }}">
							</div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="op_stock">
                                {{ trans('product.opening_stock') }} <span class="requride_cls">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="op_stock" name="op_stock" class="form-control col-md-7 col-xs-12 numberonly changefocus" placeholder="{{ trans('product.placeholder.opening_stock') }}" value="{{$product->op_stock}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price">
                                {{ trans('product.price') }} <span class="requride_cls">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="price" name="price" class="form-control col-md-7 col-xs-12 numberonly changefocus" placeholder="{{ trans('product.placeholder.price') }}" value="{{$product->price}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">
                                {{ trans('product.image') }} <span class="requride_cls">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="file" id="image" name="image" class="form-control col-md-7 col-xs-12 changefocus">
                            <input type="hidden" name="old_filename" id="old_filename" value="{{ $product->image }}">
                                @if($product->image == NULL)
                                    <a href="{{ url('/public/noimage.png') }}" target="_blank"><img src = "{{url('/public/noimage.png')}}" style="height:50px; width: 50px; margin-top: 10px;"></a>
                                @else
                                    <a href="{{ url('storage/app/'.$product->image) }}" target="_blank"><img src="{{ url('storage/app/'.$product->image) }}" style="height:50px; width: 50px; margin-top: 10px;"></a>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">
                                {{ trans('product.status') }}<span class="requride_cls">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="radio">
                                    <label style="margin-right:4%;">
                                        <input type="radio" class="status changefocus" {{ ($product->status == 1) ? 'checked' : '' }} id="status" name="status" value="1">{{ trans('product.active')}}
                                    </label>
                                    <label style="margin-right:4%;">
                                        <input type="radio" class="status changefocus" {{ ($product->status == 0) ? 'checked' : '' }} id="status" name="status" value="0">{{ trans('product.deactive')}}
                                    </label>
                                </div>
                                <label id="status-error" class="error requride_cls" for="status"></label>
                            </div>
                        </div>

						<div class="ln_solid"></div>
						<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
								<a href="{{ url('product') }}"><button type="button" class="btn btn-primary changefocus">{{ trans('product.btn.Cancel') }}</button></a>
								<button type="submit" class="btn btn-success focusClass changefocus">{{ trans('product.btn.Submit') }}</button>
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

    var checkbox_index = 1;
    $(".select2").select2({
        placeholder: "Select",
        allowClear: true,
        width:'100%'
    });

    $(".select2").select2('focus');

    $("body").on("select2-selecting", "#category_id", function(e) {
        checkbox_index = checkbox_index + 1;
        setTimeout(function() {
            $('.changefocus').eq(2).focus();
        }, 0);
    });

    $('body').on('focus', '.changefocus', function(e){
          var index = $('.changefocus').index(this);
          checkbox_index = index;
    });

    $('body').on('keydown', '.changefocus', function(e){
          if (e.which == 13) {
            e.preventDefault();
            if (checkbox_index == 7) {
                $('.changefocus').eq(9).focus();
            } else if (checkbox_index == 9) {
                $('.changefocus').eq(8).focus();
            } else if (checkbox_index == 8) {
                $('.select2').select2('focus');
            } else {
                checkbox_index = checkbox_index + 1;
                $('.changefocus').eq(checkbox_index).focus();
            }
          }
    });

    $('#frm').validate({
        rules:{
            category_id:{ required:true, },
            name:{
                required:true,
                remote:{
                    type:'POST',
                    url:"{{ url('checkProductName') }}",
                    data:{
                        id:function(){
                            return $("#id").val();
                        },
                        name:function(){
                            return $("#name").val();
                        },
                    },
                },
            },
            image: { extension: 'jpg|JPG|png|PNG|jpeg|JPEG', },
            op_stock: { required:true, },
            price: { required:true, },
            status:{ required:true, },
        },
        messages:
        {
            category_id:{ required:"{{ trans('product.message.cat_name') }}", },
            name:{ required:"{{ trans('product.message.product_name') }}", remote: "{{ trans('product.message.product_remote') }}", },
            image: { extension:"{{ trans('product.message.image') }}", },
            op_stock:{ required:"{{ trans('product.message.opening_stock') }}", },
            price:{ required:"{{ trans('product.message.price') }}", },
            status:{ required:"{{ trans('product.message.status') }}", },
        },
        errorPlacement: function(error, element) {
            error.appendTo(element.parent("div"));
        },
        submitHandler: function(form) {
            $(':input[type="submit"]').prop('disabled', true);
            form.submit();
        }
    });
});
</script>
@endsection
