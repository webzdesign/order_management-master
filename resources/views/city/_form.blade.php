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
					<h2>{{ trans('city.edit', [ 'module' => $moduleName ]) }}</h2>

					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<form id="frm" method="post"  action ="{{route('city.update', $city->id)}}"  class="form-horizontal form-label-left" autocomplete="off" enctype="multipart/form-data">
						@method('PUT')
						<input type="hidden" id="id" name="id" value="{{ $city->id }}" />
                        @csrf

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="state_id">
                                {{ trans('city.state_name') }}<span class="requride_cls">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select class="select2_single form-control" name="state_id" id="state_id">
                                    <option value=""></option>
                                    @foreach($states as $key => $val)
                                        <option {{ ($val->id == $city->state_id) ? 'selected' : '' }} value="{{ $val->id }}">{{ $val->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
								{{ trans('city.city_name') }}<span class="requride_cls">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="name" name="name" class="form-control col-md-7 col-xs-12 focusClass" placeholder="{{ trans('city.placeholder.city_name') }}" value="{{ $city->name }}">
							</div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">
                                {{ trans('city.status') }}<span class="requride_cls">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="radio">
                                <label style="margin-right:4%;">
                                    <input type="radio" class="status" {{ ($city->status == 1) ? 'checked' : '' }} id="status" name="status" value="1">{{ trans('city.active')}}
                                </label>
                                <label style="margin-right:4%;">
                                    <input type="radio" class="status" {{ ($city->status == 0) ? 'checked' : '' }} id="status" name="status" value="0">{{ trans('city.deactive')}}
                                </label>
                            </div>
                            </div>
                            <label id="status-error" class="error requride_cls" for="status"></label>
                        </div>

						<div class="ln_solid"></div>
						<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
								<a href="{{ url('city') }}" class="btn btn-primary">{{ trans('city.btn.Cancel') }}</a>
								<button type="submit" class="btn btn-success focusClass">{{ trans('city.btn.Submit') }}</button>
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
                        id:function(){
                            return $("#id").val();
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
});
</script>
@endsection
