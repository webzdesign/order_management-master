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

                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                  <label class="control-label" for="name">Name<span class="requride_cls">*</span>
                  </label>
                  <div>
                    <input type="text" id="name" name="name"  class="form-control col-md-7 col-xs-12 focusClass" placeholder="Enter Name" value="{{$user->name}}">
                  </div>
                </div>

                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                  <label class="control-label" for="email">Email<span class="requride_cls">*</span>
                  </label>
                  <div>
                    <input type="text" id="email" name="email"  class="form-control col-md-7 col-xs-12 focusClass" placeholder="Enter Email" value="{{$user->email}}">

                  </div>
                </div>

                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                  <label class="control-label" for="password">Password<span class="requride_cls">*</span>
                  </label>
                  <div>
                    <input type="password" id="password" name="password"  class="form-control col-md-7 col-xs-12 focusClass" placeholder="Enter Password">
                  </div>
                </div>


                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                  <label class="control-label" for="confirm_password">Confirm Password<span class="requride_cls">*</span>
                  </label>
                  <div>
                    <input type="password" id="confirm_password" name="confirm_password"  class="form-control col-md-7 col-xs-12 focusClass" placeholder="Enter Confirm Password" >
                  </div>
                </div>

                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                  <label class="control-label" for="status">
                    Status <span class="requride_cls">*</span>
                  </label>
                  <div>
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

                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                  <label class="control-label" for="role">
                    Select Role
                  </label>
                  <div>
                    <select class="select2_single form-control" name="role" id="role">
                        <option value="">Select</option>
                        @foreach($role_details as $key=>$value)
                          <option value="{{$value->id}}" {{ ($value->id == $user->roles[0]->id) ? 'selected': ''}}>{{$value->name}}</option>
                        @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group col-md-12 col-sm-12 col-xs-12 ln_solid"></div>

                <div class="form-group">
                    <label for="name">Permissions :</label>

                    <div class="col-lg-12 permission-card">
                    @php $cnt = 1; @endphp
                    @foreach($permissions as $k=>$permission)
                        @if($cnt%3 == 1)
                            <div class="row">
                        @endif
                            <div class="col-lg-4 permission-listing">
                                <div class="permissionHeader">{{ $k }} <a class="pull-right selectDeselect deselectalltitle" value="deselect">Deselect All</a> <a class="pull-right selectDeselect selectalltitle" value="select">Select All</a></div>
                                @foreach($permission as $key=>$val)
                                <div class="checkbox">
                                    <label class="permissionOption"><input type="checkbox" class="permission-options permission" name="permission[]" @if(in_array($val->id,$existPermission)) checked @endif value="{{ $val->id }}"> {{ $val->name }} </label>
                                </div>
                                @endforeach
                            </div>
                        @if($cnt%3 == 0)
                            </div>
                            <hr class="form-part">
                        @endif
                        @php $cnt++; @endphp
                    @endforeach
                    </div>
                </div>

                <div class="form-group col-md-12 col-sm-12 col-xs-12 ln_solid"></div>

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

      $('body').on('click','.selectDeselect',function(e){
        var selectVal = $(this).attr('value');
        console.log(selectVal);
        if(selectVal == 'select'){
            $(this).closest('.permission-listing').find(".permission").prop("checked", true);
        }else{
            $(this).closest('.permission-listing').find(".permission").prop("checked", false);
        }
    });
    
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
          role:{
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
            role:{
              required:"Role Is Required",
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
