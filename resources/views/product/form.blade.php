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
                <h2>{{ trans('product.add', [ 'module' => $moduleName ]) }}</h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form id="frm" method="post"  action ="{{route('product.store')}}"  class="form-horizontal form-label-left" autocomplete="off" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_id">
                            {{ trans('product.cat_name') }} <span class="requride_cls">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="select2_single form-control" name="category_id" id="category_id">
                                <option value=""></option>
                                @foreach($category as $key => $val)
                                    <option value="{{ $val->id }}">{{ $val->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                            {{ trans('product.product_name') }}  <span class="requride_cls">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="name" name="name" class="form-control col-md-7 col-xs-12" placeholder="{{ trans('product.placeholder.product_name') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="op_stock">
                            {{ trans('product.opening_stock') }} <span class="requride_cls">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="op_stock" name="op_stock" class="form-control col-md-7 col-xs-12 numberonly" placeholder="{{ trans('product.placeholder.opening_stock') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price">
                            {{ trans('product.price') }} <span class="requride_cls">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="price" name="price" class="form-control col-md-7 col-xs-12 numberonly" placeholder="{{ trans('product.placeholder.price') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">
                            {{ trans('product.image') }}
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="file" id="image" name="image" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">
                            {{ trans('product.status') }}<span class="requride_cls">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="radio">
                            <label style="margin-right:4%;">
                                <input type="radio" class="status" checked id="status" name="status" value="1">{{ trans('product.active')}}
                            </label>
                            <label style="margin-right:4%;">
                                <input type="radio" class="status" id="status" name="status" value="0">{{ trans('product.deactive')}}
                            </label>
                        </div>
                        </div>
                        <label id="status-error" class="error requride_cls" for="status"></label>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <a href=" {{ url('product') }}" class="btn btn-primary">{{ trans('product.btn.Cancel') }}</a>
                            <button type="submit" class="btn btn-success">{{ trans('product.btn.Submit') }}</button>
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
    $('#frm').validate({
        rules:{
            category_id:{ required:true, },
            name:{
                required:true,
                remote:{
                    type:'POST',
                    url:"{{ url('checkProductName') }}",
                    data:{
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
