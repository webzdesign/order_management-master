@extends('layouts.master')
@section('content')

<div class="right_col" role="main">
    <div class="">
    <div class="page-title">
        <div class="title_left">
        </div>
        <div class="title_right">
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                <h2>Change Password</h2>
                <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form role="form" class="form-horizontal form-label-left" method="post" action="{{ url('updatePassword') }}" id="frm">
                        @csrf
                        <div class="form-group">
                            <label class="col-md-3 col-sm-3 col-xs-12 control-label">Old Password <span class="requride_cls">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="password" class="form-control col-md-7 col-xs-12" id="old_password" name="old_password" placeholder="Enter your Old Password"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-sm-3 col-xs-12 control-label">New Password <span class="requride_cls">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="password" class="form-control col-md-7 col-xs-12" name="password" id="password" placeholder="Enter your New Password"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-sm-3 col-xs-12 control-label">Confirm Password <span class="requride_cls">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password"/>
                            </div>
                        </div>

                        <div class="ln_solid"></div>

                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <input type="submit" id="form_btn" value="Update" class="btn btn-primary"/>
                            <a href="{{url('/home')}}" class="btn btn-warning" >Cancel </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection
@section('script')
<script>
jQuery(document).ready(function() {

    @if (Session::has('message'))
    new PNotify({
        title: '{{ $moduleName }}',
        text: '{!! session('message') !!}',
        type: 'success',
        styling: 'bootstrap3',
        delay: 1500,
        animation: 'fade',
        animateSpeed: 'slow'
    });
    @endif

    $('#frm').validate({
        rules:
        {
            old_password:{
                required:true,
                remote:{
                    type:'POST',
                    url:"{{url('/checkOldPassword')}}",
                    data:{
                        old_password:function(){
                            return $("#old_password").val();
                        },
                    },
                },
            },
            password:{
                required: true,
                minlength: 6,
                maxlength:10,
            },
            confirmpassword: {
                required: true,
                equalTo: "#password"
            },
        },
        messages:
        {
            old_password:{
                required:"Old Password Is Required",
                remote:"Old Password Is Wrong",
            },
            password:{
                required:"New Password Is Required",
                minlength:"Password Minimum 6 Characters",
                maxlength:"Password Maximum 10 Characters"
            },
            confirmpassword:{
                required:"Confirm Password Is Required",
                equalTo:"Password And Confirm Password Does Not Match",
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
