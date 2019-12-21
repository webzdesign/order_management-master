@extends('layouts.master')
@section('title')
{{$moduleName}}
@endsection
  @section('content')
  <!-- page content -->
  <div class="right_col" role="main">
    <div class="">
        <div class="title_left">
          <a href="{{url('product')}}"><button class="btn btn-primary" >Back</button></a>
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
              <br />
              <form id="frm" method="post"  action ="{{route('product.update', $product->id)}}"  class="form-horizontal form-label-left" autocomplete="off" enctype="multipart/form-data">
                @method('PUT')
                <input type="hidden" id="id" name="id" value="{{$product->id}}" />
                @csrf

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_id">
                    Category <span class="requride_cls">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="select2_single form-control" name="category_id" id="category_id">
                      <option value="">Select</option>
                      @foreach($category as $key=>$value)
                      <option value="{{$value->id}}" {{ ($value->id == $product->category_id) ? 'selected' : '' }}>{{$value->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name<span class="requride_cls">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="name" name="name"  class="form-control col-md-7 col-xs-12 focusClass" placeholder="Enter Name" value="{{$product->name}}">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">Image
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="file" id="image" name="image" class="form-control">
                      <input type="hidden" name="old_filename" id="old_filename" value="{{ $product->image }}">
                      @if($product->image == '')
                        <a href="{{ url('/storage/app/product/saral_logo.jpg') }}" target="_blank"><img src="{{ url('/storage/app/product/saral_logo.jpg') }}" style="height:75px; width: 100px; margin-top: 10px;"></a>
                      @else
                        <a href="{{ url('/storage/app/'.$product->image) }}" target="_blank"><img src="{{ url('/storage/app/'.$product->image) }}" style="height:50px; width: 50px; margin-top: 10px;"></a>
                      @endif

                  </div>
               </div>


                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">
                    Status <span class="requride_cls">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="radio">
                      <label style="margin-right:20px;">
                        <input type="radio" value="1" name="status" {{ ($product->status == 1) ? 'checked' : '' }}>Active
                      </label>
                      <label>
                        <input type="radio" value="0" name="status" {{ ($product->status == 0) ? 'checked' : '' }}>Deactive
                      </label>
                    </div>
                    <label id="status-error" class="error" for="status"></label>
                  </div>
                </div>

                <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                      <a href="{{url('product')}}" class="btn btn-primary">Cancel</a>
                    <button type="submit" class="btn btn-success focusClass">Submit</button>
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
      $('#frm').validate({
        rules:{
          category_id:{
            required:true,
          },
          name:{
            required:true,
          },
          image:{
            extension: 'jpg|JPG|png|PNG|jpeg|JPEG',
          },
          status:{
            required:true,
          },
        },
        messages:
        {
          category_id:{
            required:"Category Is Required",
          },
          name:{
            required:"Name Is Required",
          },
          image:{
            extension:"Only JPG / PNG / JPEG Format Allowed.",
          },
          status:{
            required:"Status Is Required",
          },
        },
        errorPlacement: function(error, element){
          if(element.is('select')) {
              error.insertAfter(element.next());
          } else {
              error.insertAfter(element);
          }
        },
        submitHandler: function(form) {
          $(':input[type="submit"]').prop('disabled', true);
          form.submit();
        }
      });
    });
  </script>
  @endsection
