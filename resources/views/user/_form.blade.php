  @extends('layouts.master')
  @section('title')
  {{$moduleName}}
  @endsection
  @section('content')
  <!-- page content -->
  <div class="right_col" role="main">
    <div class="">
        <div class="title_left">
          <a href="{{route('user.index')}}"><button class="btn btn-primary" >Back</button></a>
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
              <form id="frm" method="post"  action ="{{route('user.update', $user->id)}}"  class="form-horizontal form-label-left" autocomplete="off" enctype="multipart/form-data">
                @method('PUT')
                <input type="hidden" id="id" name="id" value="{{$user->id}}" />
                @csrf

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name<span class="requride_cls">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="name" name="name"  class="form-control col-md-7 col-xs-12 focusClass" placeholder="Enter Name" value="{{$user->name}}">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email<span class="requride_cls">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="email" name="email"  class="form-control col-md-7 col-xs-12 focusClass" placeholder="Enter Email" value="{{$user->email}}">

                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Password<span class="requride_cls">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="password" id="password" name="password"  class="form-control col-md-7 col-xs-12 focusClass" placeholder="Enter Password">
                  </div>
                </div>


                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="confirm_password">Confirm Password<span class="requride_cls">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="password" id="confirm_password" name="confirm_password"  class="form-control col-md-7 col-xs-12 focusClass" placeholder="Enter Confirm Password" >
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">
                    Status <span class="requride_cls">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="radio">
                      <label style="margin-right:20px;">
                        <input type="radio" value="1" name="status" {{($user->status == 1) ? 'checked' : '' }}>Active
                      </label>
                      <label>
                        <input type="radio" value="0" name="status" {{($user->status == 0) ? 'checked' : '' }}>Deactive
                      </label>
                    </div>
                    <label id="status-error" class="error" for="status"></label>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="display">
                    Display All Dealer
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <label>
                      <input type="checkbox" id="display" name="display" value="1" 
                      {{ ($user->display == 1) ? 'checked':'' }}> Yes
                    </label>
                  </div>
                </div>

                <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                      <a href="{{route('user.index')}}" class="btn btn-primary">Cancel</a>
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
          name:{
            required:true,
          },
          email:{
            required:true,
            email:true,
            remote:{
              type:'POST',
              url:"{{url('/checkUserEmail')}}",
              data:{
                email:function(){
                  return $("#email").val();
                },
                id:function(){
                  return $("#id").val();
                },
              },
            },
          },
          password:{
            minlength:6,
            maxlength:10,
          },
          confirm_password:{
            equalTo: "#password"
          },
          status:{
            required:true,
          },
        },
        messages:
        {
            name:{
              required:"Name Is Required",
            },
            email:{
              required:"Email Is Required",
              remote: "Email Already exits",
            },
            password:{
              minlength:"Password Minimum 6 Characters",
              maxlength:"Password Maximum 10 Characters"
            },
            confirm_password:{
              equalTo: " Enter Confirm Password Same as Password"
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
