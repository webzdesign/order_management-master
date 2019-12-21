@extends('layouts.master')
@section('title')
{{$moduleName}}
@endsection
  @section('content')
  <!-- page content -->
  <div class="right_col" role="main">
    <div class="">
      <div class="title_left">
        <a href="{{route('dealer.index')}}"><button class="btn btn-primary" >Back</button></a>
      </div>
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Add {{$moduleName}}</h2>

              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <br />
              <form id="frm" method="post"  action ="{{route('dealer.store')}}"  class="form-horizontal form-label-left" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="city_id">
                    City <span class="requride_cls">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="select2_single form-control" name="city_id" id="city_id">
                      <option value="">Select</option>
                      @foreach($city as $key=>$value)
                      <option value="{{$value->id}}">{{$value->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_id">
                    Salesman <span class="requride_cls">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="select2_single form-control" name="user_id" id="user_id">
                      <option value="">Select</option>
                      @foreach($user as $key=>$value)
                      <option value="{{$value->id}}">{{$value->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name<span class="requride_cls">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="name" name="name"  class="form-control col-md-7 col-xs-12 focusClass" placeholder="Enter Name" value="{{old('name')}}">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">
                    Status <span class="requride_cls">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="radio">
                      <label style="margin-right:20px;">
                        <input type="radio" value="1" name="status">Active
                      </label>
                      <label>
                        <input type="radio" value="0" name="status">Deactive
                      </label>
                    </div>
                    <label id="status-error" class="error" for="status"></label>
                  </div>
                </div>

                <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href=" {{ url('dealer') }}" class="btn btn-primary">Cancel</a>
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
          city_id:{
            required:true,
          },
          user_id:{
            required:true,
          },
          name:{
            required:true,
          },
          status:{
            required:true,
          },
        },
        messages:
        {
          city_id:{
            required:"City Is Required",
          },
          user_id:{
            required:"Salesman Is Required",
          },
          name:{
            required:"Name Is Required",
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
