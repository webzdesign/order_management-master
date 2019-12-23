@extends('layouts.master')
@section('title')
{{$moduleName}}
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
                <h2>Add {{$moduleName}}</h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form id="frm" method="post"  action ="{{route('state.store')}}"  class="form-horizontal form-label-left" autocomplete="off" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                            State Name<span class="requride_cls">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="name" name="name"  class="form-control col-md-7 col-xs-12" placeholder="Enter State Name">
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <a href=" {{ url('state') }}" class="btn btn-primary">Cancel</a>
                        <button type="submit" class="btn btn-success">Submit</button>
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
        },
        messages:
        {
            name:{ required:"State Name Is Required", remote: "State Name Already Exits", },
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
