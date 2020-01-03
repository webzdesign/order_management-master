@extends('layouts.master')
@section('title')
{{$moduleName}} - {{ Helper::setting()->name }}
@endsection
@section('content')
<!-- page content -->
<div class="right_col" role="main">
    <div class="title_left">
        <a href="{{ url('city') }}"><button class="btn btn-primary" >{{ trans('city.btn.Back') }}</button></a>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
            <div class="x_title">
                <h2>{{ trans('city.add', [ 'module' => $moduleName ]) }}</h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form id="frm" method="post"  action ="{{route('city.store')}}"  class="form-horizontal form-label-left" autocomplete="off" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="state_id">
                            {{ trans('city.state_name') }} <span class="requride_cls">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="select2 state_id" name="state_id" id="state_id" style="width:100%;">
                                <option value=""></option>
                                @foreach($states as $key => $val)
                                    <option value="{{ $val->id }}">{{ $val->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                            {{ trans('city.city_name') }}<span class="requride_cls">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="name" name="name" class="form-control col-md-7 col-xs-12 name" placeholder="{{ trans('city.placeholder.city_name') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">
                            {{ trans('city.status') }}<span class="requride_cls">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="radio">
                            <label style="margin-right:4%;">
                                <input type="radio" class="status" checked id="status" name="status" value="1">{{ trans('city.active')}}
                            </label>
                            <label style="margin-right:4%;">
                                <input type="radio" class="status" id="status" name="status" value="0">{{ trans('city.deactive')}}
                            </label>
                        </div>
                        </div>
                        <label id="status-error" class="error requride_cls" for="status"></label>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <a href=" {{ url('city') }}" class="btn btn-primary">{{ trans('city.btn.Cancel') }}</a>
                            <button type="submit" class="btn btn-success">{{ trans('city.btn.Submit') }}</button>
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
            state_id:{ required:true, },
            name:{
                required:true,
                remote:{
                    type:'POST',
                    url:"{{ url('checkCityName') }}",
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
            state_id:{ required:"{{ trans('city.message.state_name') }}", },
            name:{ required:"{{ trans('city.message.city_name') }}", remote: "{{ trans('city.message.city_remote') }}", },
            status:{ required:"{{ trans('city.message.status') }}", },
        },
        errorPlacement: function(error, element) {
            error.appendTo(element.parent("div"));
        },
        submitHandler: function(form) {
            $(':input[type="submit"]').prop('disabled', true);
            form.submit();
        }
    });

    $("body").on("keydown", ".select2", function(e) {
		var $currentTarget = e.currentTarget;
		var key_code = e.which || e.keyCode;
		if($($currentTarget).attr("id") == "s2id_party"){
			if(key_code == 9) {
				if(e.shiftKey) {
					$("button[type=submit]").focus();
					e.preventDefault();
				}
			}
			else if(key_code == 13){
				var $selectTag = $(".name");
				setTimeout(function() {
					$($selectTag).focus();
				}, 0);
			}
		}
	});

	$("body").on("select2-selecting", ".state_id", function(event){

		var $currentTarget = event.currentTarget;
		var $tr = $($currentTarget).closest("tr");
		var $trRowIndex = $tr.index();
		var key_code = event.which || event.keyCode;
		var $selectTag = $(".name");
		setTimeout(function() {
				$($selectTag).focus();
		}, 0);
    });

    $("body").on("keydown", ".name", function(event){
		var $currentTarget = event.currentTarget;
		var $tr = $($currentTarget).closest("tr");
		var $trRowIndex = $tr.index();
		var key_code = event.which || event.keyCode;
		var $inputID = $(".status:first");
		var $prevID = $(".name");
		if(key_code == 13){
			$($inputID).focus();
			event.preventDefault();
		}else if(key_code == 9) {
			if(event.shiftKey) {
				$($prevID).select2('focus');
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
		//alert($(".status:eq(0)").attr(id));
		var $inputID=$(".status:last");
		var $prevID=$(".name");
		//alert($th.index());
		if($th.index() == 0){
			//alert('first');
			$inputID = $(".status:last");
			$prevID = $(".name");
		}
		else {
            //alert('sec');
			//alert($('.status:checked').length);
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
        var $prevID = $(".name");
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


    $(".select2").select2({
		placeholder: "Select",
		allowClear: true
	});

	$(".state_id").select2('focus');

});
</script>
@endsection
