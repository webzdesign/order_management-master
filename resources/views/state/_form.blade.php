@extends('layouts.master')
@section('title')
{{$moduleName}} - {{ Helper::setting()->name }}
@endsection
@section('content')
<!-- page content -->
<div class="right_col" role="main">
	<div class="title_left">
		<a href="{{ url('state') }}"><button class="btn btn-primary" >Back</button></a>
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
					<form id="frm" method="post"  action ="{{route('state.update', $state->id)}}"  class="form-horizontal form-label-left" autocomplete="off" enctype="multipart/form-data">
						@method('PUT')
						<input type="hidden" id="id" name="id" value="{{ $state->id }}" />
						@csrf

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
								State Name<span class="requride_cls">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="name" name="name" class="form-control col-md-7 col-xs-12 focusClass" placeholder="Enter State Name" value="{{ $state->name }}">
							</div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">
                                Status<span class="requride_cls">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="radio">
                                <label style="margin-right:4%;">
                                    <input type="radio" class="status" {{ ($state->status == 1) ? 'checked' : '' }} id="status" name="status" value="1">Active
                                </label>
                                <label style="margin-right:4%;">
                                    <input type="radio" class="status" {{ ($state->status == 0) ? 'checked' : '' }} id="status" name="status" value="2">Deactive
                                </label>
                            </div>
                            </div>
                            <label id="status-error" class="error requride_cls" for="status"></label>
                        </div>

						<div class="ln_solid"></div>
						<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
								<a href="{{ url('state') }}" class="btn btn-primary">Cancel</a>
								<button type="submit" class="btn btn-success focusClass">Submit</button>
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
            name:{ required:"State Name Is Required", remote: "State Name Already Exits", },
            status:{ required:"Status Is Required.", },
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
