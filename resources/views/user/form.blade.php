@extends('layouts.master')
@section('title')
{{$moduleName}}
@endsection
  @section('content')
  <!-- page content -->
  <div class="right_col" role="main">
    <div class="">
      <div class="title_left">
        <a href="{{route('user.index')}}"><button class="btn btn-primary" >{{ trans('user.btn.Back') }}</button></a>
      </div>
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>{{ trans('user.add', [ 'module' => $moduleName ]) }}</h2>

              <div class="clearfix"></div>
            </div>
            <div class="x_content">

              <form id="frm" method="post"  action ="{{route('user.store')}}"  class="form-horizontal form-label-left" autocomplete="off" enctype="multipart/form-data">
                @csrf

                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                  <label class="control-label" for="name">{{ trans('user.user_name') }}<span class="requride_cls">*</span>
                  </label>
                  <div>
                    <input type="text" id="name" name="name"  class="form-control col-md-7 col-xs-12 focusClass" placeholder="Enter Name" value="{{old('name')}}">
                  </div>
                </div>

                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                  <label class="control-label" for="email">{{ trans('user.user_email') }}<span class="requride_cls">*</span>
                  </label>
                  <div>
                    <input type="text" id="email" name="email"  class="form-control col-md-7 col-xs-12 focusClass" placeholder="Enter Email" value="{{old('email')}}">
                  </div>
                </div>

                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                  <label class="control-label" for="password">{{ trans('user.password') }}<span class="requride_cls">*</span>
                  </label>
                  <div>
                    <input type="password" id="password" name="password"  class="form-control col-md-7 col-xs-12 focusClass" placeholder="Enter Password" value="{{old('password')}}" >
                  </div>
                </div>


                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                  <label class="control-label" for="confirm_password">{{ trans('user.confirm_password') }}<span class="requride_cls">*</span>
                  </label>
                  <div>
                    <input type="password" id="confirm_password" name="confirm_password"  class="form-control col-md-7 col-xs-12 focusClass" placeholder="Enter Confirm Password" value="{{old('confirm_password')}}" >
                  </div>
                </div>

                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                  <label class="control-label" for="status">{{ trans('user.status') }}
                     <span class="requride_cls">*</span>
                  </label>
                  <div>
                    <div class="radio">
                      <label style="margin-right:20px;">
                        <input type="radio" value="1" name="status" checked>Active
                      </label>
                      <label>
                        <input type="radio" value="0" name="status">Deactive
                      </label>
                    </div>
                    <label id="status-error" class="error" for="status"></label>
                  </div>
                </div>

                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                  <label class="control-label" for="role">
                    {{ trans('user.select_role') }}
                  </label>
                  <div>
                    <select class="select2_single form-control" name="role" id="role">
                        <option value="">Select</option>
                        @foreach($role_details as $key=>$value)
                          <option value="{{$value->id}}">{{$value->name}}</option>
                        @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group col-md-12 col-sm-12 col-xs-12 ln_solid"></div>
                <div class="form-group">
                            <label for="name">{{ trans('user.permissions') }} :</label>

                            <div class="col-lg-12 permission-card">
                            @php $cnt = 1; @endphp
                            @foreach($permissions as $k=>$permission)
                                @if($cnt%3 == 1)
                                    <div class="row">
                                @endif
                                    <div class="col-lg-4 permission-listing">
                                        <div class="permissionHeader"> - {{ $k }} <a class="pull-right selectDeselect deselectalltitle" value="deselect">Deselect All</a> <a class="pull-right selectDeselect selectalltitle" value="select">Select All</a></div>
                                        @foreach($permission as $key=>$val)
                                        <div class="checkbox">
                                            <label class="permissionOption"><input type="checkbox" class="permission-options permission" name="permission[]" value="{{ $val->id }}"> {{ $val->name }} </label>
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
                  <div class="col-md-4 col-sm-4 col-xs-12 col-md-offset-3">
                    <a href=" {{ url('user') }}" class="btn btn-primary">{{ trans('user.btn.Cancel') }}</a>
                    <button type="submit" class="btn btn-success focusClass">{{ trans('user.btn.Cancel') }}</button>
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
              },
            },
          },
          password:{
            required:true,
            minlength:6,
            maxlength:10,
          },
          confirm_password:{
            required:true,
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
              required:"Enter Password",
              minlength:"Password Minimum 6 Characters",
              maxlength:"Password Maximum 10 Characters"
            },
            confirm_password:{
              required:"Confirm Password Is Required",
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
