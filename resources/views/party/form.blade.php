@extends('layouts.master')
@section('title')
{{$moduleName}} - {{ Helper::setting()->name }}
@endsection
@section('content')
<!-- page content -->
<div class="right_col" role="main">
    <div class="title_left">
        <a href="{{ url('party') }}"><button class="btn btn-primary" >Back</button></a>
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
                <form id="frm" method="post"  action ="{{ route('party.store') }}"  class="form-horizontal form-label-left" autocomplete="off" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label for="name">
                                    Party Name <span class="requride_cls">*</span>
                                </label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Enter Party Name">
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label for="mobile_no">
                                    Party Mobile <span class="requride_cls">*</span>
                                </label>
                                <input type="text" id="mobile_no" name="mobile_no" class="form-control numberonly" minlength="10" maxlength="10" placeholder="Enter Party Mobile No">
                            </div>
                        </div>
                    </div>

                    <hr class="hrClass">

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label for="state_id">
                                    State Name <span class="requride_cls">*</span>
                                </label>
                                <select class="select2_single form-control" name="state_id" id="state_id">
                                    <option value=""></option>
                                    @foreach($states as $key => $val)
                                        <option value="{{ $val->id }}">{{ $val->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label for="city_id">
                                    City Name <span class="requride_cls">*</span>
                                </label>
                                <select class="select2_single form-control" name="city_id" id="city_id">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr class="hrClass">

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label for="city_id">
                                    Party Address <span class="requride_cls">*</span>
                                </label>
                                <textarea id="address" name="address" class="form-control numberonly" placeholder="Enter party Address"></textarea>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label for="status">
                                    Status <span class="requride_cls">*</span>
                                </label>

                                <div class="radio">
                                    <label style="margin-right:20px;">
                                        <input type="radio" value="1" checked  name="status">Active
                                    </label>
                                    <label>
                                        <input type="radio" value="0" name="status">Deactive
                                    </label>
                                </div>
                                <label id="status-error" class="error" for="status"></label>
                            </div>
                        </div>
                    </div>


                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <a href=" {{ url('party') }}" class="btn btn-primary">Cancel</a>
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
            name:{ required:true, },
            mobile_no:{
                required:true,
                remote:{
                    type:'POST',
                    url:"{{ url('checkPartyMobile') }}",
                    data:{
                        mobile_no:function(){
                            return $("#mobile_no").val();
                        },
                    },
                },
            },
            state_id:{ required:true, },
            city_id:{ required:true, },
            address:{ required:true, },
            status:{ required:true, },
        },
        messages:
        {
            state_id:{ required:"State Is Required.", },
            name:{ required:"City Name Is Required.", remote: "City Name Already Exits.", },
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
