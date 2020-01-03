@extends('layouts.master')
@section('title')
{{$moduleName}} - {{ Helper::setting()->name }}
@endsection
@section('content')
<!-- page content -->
<div class="right_col" role="main">
    <div class="title_left">
        <a href="{{ url('state') }}"><button class="btn btn-primary" >{{ trans('state.btn.Back') }}</button></a>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
            <div class="x_title">
                <h2>{{ trans('state.add', [ 'module' => $moduleName ]) }}</h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form id="frm" method="post"  action ="{{route('state.store')}}"  class="form-horizontal form-label-left" autocomplete="off" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                            {{ trans('state.state_name') }}<span class="requride_cls">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="name" name="name" class="form-control col-md-7 col-xs-12 name" placeholder="{{ trans('state.placeholder.state_name') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">
                            {{ trans('state.status') }}<span class="requride_cls">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="radio">
                            <label style="margin-right:4%;">
                                <input type="radio" class="status" checked id="status" name="status" value="1">{{ trans('state.active')}}
                            </label>
                            <label style="margin-right:4%;">
                                <input type="radio" class="status" id="status" name="status" value="0">{{ trans('state.deactive')}}
                            </label>
                        </div>
                        </div>
                        <label id="status-error" class="error requride_cls" for="status"></label>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <a href=" {{ url('state') }}" class="btn btn-primary">{{ trans('state.btn.Cancel') }}</a>
                            <button type="submit" class="btn btn-success">{{ trans('state.btn.Submit') }}</button>
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
            name:{
                required:true,
                remote:{
                    type:'POST',
                    url:"{{ url('checkStateName') }}",
                    data:{
                        name:function(){
                            return $("#name").val();
                        },
                    },
                },
            },
            status:{ required:true, },
        },
        messages:
        {
            name:{ required:"{{ trans('state.message.state_name') }}", remote: "{{ trans('state.message.state_remote') }}", },
            status:{ required:"{{ trans('state.message.status') }}", },
        },
        errorPlacement: function(error, element) {
            error.appendTo(element.parent("div"));
        },
        submitHandler: function(form) {
            $(':input[type="submit"]').prop('disabled', true);
            form.submit();
        }
    });

    $("body").on("keydown", ".name", function(event){
		var $currentTarget = event.currentTarget;
		var $tr = $($currentTarget).closest("tr");
		var $trRowIndex = $tr.index();
		var key_code = event.which || event.keyCode;
		var $inputID = $(".status:first");
		var $prevID = $("button[type=submit]");
		if(key_code == 13){
			$($inputID).focus();
			event.preventDefault();
		}else if(key_code == 9) {
			if(event.shiftKey) {
				$($prevID).focus();
				event.preventDefault();
			}else{
				$($inputID).focus();
				event.preventDefault();
			}
		}
	});


  $("body").on("keydown", ".status", function(event){
    var $currentTarget = event.currentTarget;
    var $tr = $($currentTarget).closest("tr");
    var $th=$(this);

    var $trRowIndex = $tr.index();
    var key_code = event.which || event.keyCode;
    //alert($(".amount_paid:eq(0)").attr(id);
    var $inputID=$(".status:last");
    var $prevID=$(".name");

	//alert($th.index());
    if($th.index() == 0){
        //alert('first');
        $inputID = $(".status:last");
        $prevID = $(".name");
    }
    else if($th.index() == 1){
        //alert('we');
        //alert($('.amount_paid:checked').length);
        if($('.status:checked').length==0)
        {
            $inputID = $("button[type=submit]");
        }
        else if($th.is(':checked'))
        {
            $inputID = $("button[type=submit]");
        }
        else
        {
            //$inputID = $(".amount");
            $inputID = $("button[type=submit]");
        }
        $prevID = $(".status:first");
    }

    if(key_code == 13){
        $($inputID).focus();
        event.preventDefault();
    }else if(key_code == 9) {
        if(event.shiftKey) {
            $($prevID).focus();
            event.preventDefault();
        }else{
            $($inputID).focus();
            event.preventDefault();
        }
    }else if(key_code == 32)
        {
            $th.trigger("click");
        }
});

    $("body").on("keydown", "button[type=submit]", function(event){
        var keyCode = event.keyCode || event.which;
        var $th = $(this);
        var $prevID = $(".status");

        if(keyCode == 13) {

            $("#frm").select2('focus');
            event.preventDefault();
        }
        else if(keyCode == 9) {
            if(event.shiftKey) {
            } else {
                $("#frm").select2('focus');
                event.preventDefault();
            }
        } else if(keyCode == 32)
        {
            $th.trigger("click");
        }
    });
    $('#name').focus();
});
</script>
@endsection
