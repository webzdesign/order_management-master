@extends('layouts.master')
@section('title')
{{$moduleName}}
@endsection
  @section('content')
  <!-- page content -->
  <div class="right_col" role="main">
    <div class="">
        <div class="title_left">
          <a href="{{url('order')}}"><button class="btn btn-primary" >Back</button></a>
        </div>
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>View {{$moduleName}}</h2>

              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <br />
              <form id="frm" method="post"   class="form-horizontal form-label-left" autocomplete="off" enctype="multipart/form-data">

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="order_no">Order No<span class="requride_cls">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="order_no" name="order_no"  class="form-control col-md-7 col-xs-12 focusClass" placeholder="Enter Order No" value="{{$order[0]->order_no}}" readonly>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="date">Date<span class="requride_cls">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="date" name="date"  class="form-control col-md-7 col-xs-12 focusClass" placeholder="Enter Date" value="{{ date("d-m-Y", strtotime($order[0]->date))}}" readonly>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dealer_id">
                    Dealer <span class="requride_cls">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="select2_single form-control" name="dealer_id" id="dealer_id" disabled>
                      <option value="">Select</option>
                      @foreach($dealer as $key=>$value)
                      <option value="{{$value->id}}" {{ ($value->id == $order[0]->dealer_id) ? 'selected' : '' }}>{{$value->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="city_id">
                    City <span class="requride_cls">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="select2_single form-control" name="city_id" id="city_id" disabled>
                      <option value="">Select</option>
                      @foreach($city as $key=>$value)
                      <option value="{{$value->id}}" {{ ($value->id == $order[0]->city_id) ? 'selected' : '' }}>{{$value->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="instruction">Instruction<span class="requride_cls">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="instruction" name="instruction"  class="form-control col-md-7 col-xs-12 focusClass" placeholder="Enter Instruction" value="{{$order[0]->instruction}}" readonly>
                  </div>
                </div>

                <table class="datatable mdl-data-table dataTable table table-striped table-bordered" cellspacing="0"
                width="100%" role="grid" style="width: 100%;">
                  <thead>
                    <tr>
                      <th>Sr No</th>
                      <th>Product</th>
                      <th>Qty</th>
                    </tr>
                  </thead>
                  <tbody>

                    @foreach($order as $key=>$value)
                    <tr>
                      <td>{{ $key+1}}</td>
                      <td>{{ $value->product->name }}</td>
                      <td>{{ $value->qty}}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>



                <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                      <a href="{{url('order')}}" class="btn btn-primary">Cancel</a>
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
