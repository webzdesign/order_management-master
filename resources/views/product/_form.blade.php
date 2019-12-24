@extends('layouts.master')
@section('title')
{{$moduleName}} - {{ Helper::setting()->name }}
@endsection
@section('content')
<!-- page content -->
<div class="right_col" role="main">
	<div class="title_left">
		<a href="{{ url('product') }}"><button class="btn btn-primary" >Back</button></a>
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
					<form id="frm" method="post"  action ="{{route('product.update', $product->id)}}"  class="form-horizontal form-label-left" autocomplete="off" enctype="multipart/form-data">
						@method('PUT')
						<input type="hidden" id="id" name="id" value="{{ $product->id }}" />
                        @csrf

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_id">
                                Category Name <span class="requride_cls">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select class="select2_single form-control" name="category_id" id="category_id">
                                    <option value=""></option>
                                    @foreach($category as $key => $val)
                                        <option {{ ($val->id == $product->category_id) ? 'selected' : '' }} value="{{ $val->id }}">{{ $val->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
								Product Name<span class="requride_cls">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="name" name="name" class="form-control col-md-7 col-xs-12 focusClass" placeholder="Enter Product Name" value="{{ $product->name }}">
							</div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="op_stock">
                                Opening Stock <span class="requride_cls">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="op_stock" name="op_stock" class="form-control col-md-7 col-xs-12 numberonly" placeholder="Enter Opening Stock" value="{{$product->op_stock}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price">
                                Price <span class="requride_cls">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="price" name="price" class="form-control col-md-7 col-xs-12 numberonly" placeholder="Enter Price" value="{{$product->price}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">
                                Image <span class="requride_cls">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="file" id="image" name="image" >
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
                                Status<span class="requride_cls">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="radio">
                                    <label style="margin-right:4%;">
                                        <input type="radio" class="status" {{ ($product->status == 1) ? 'checked' : '' }} id="status" name="status" value="1">Active
                                    </label>
                                    <label style="margin-right:4%;">
                                        <input type="radio" class="status" {{ ($product->status == 0) ? 'checked' : '' }} id="status" name="status" value="0">Deactive
                                    </label>
                                </div>
                                <label id="status-error" class="error requride_cls" for="status"></label>
                            </div>
                        </div>

						<div class="ln_solid"></div>
						<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
								<a href="{{ url('product') }}" class="btn btn-primary">Cancel</a>
								<button type="submit" class="btn btn-success focusClass">Submit</button>
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
            category_id:{ required:"Category Is Required.", },
            name:{ required:"Product Name Is Required.", remote: "Product Name Already Exits.", },
            image: { extension:"Only JPG / PNG / JPEG Format Allowed.", },
            op_stock:{ required:"Opening Stock Is Required.", },
            price:{ required:"Price Is Required.", },
            status:{ required:"Status Is Required.", },
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
