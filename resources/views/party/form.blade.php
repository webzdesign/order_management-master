@extends('layouts.master')
@section('title')
{{$moduleName}} - {{ Helper::setting()->name }}
@endsection
@section('content')
<!-- page content -->
<div class="right_col" role="main">
    <div class="title_left">
        <a href="{{ url('party') }}"><button class="btn btn-primary" >{{ trans('party.btn.Back') }}</button></a>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
            <div class="x_title">
                <h2>{{ trans('party.add', [ 'module' => $moduleName ]) }}</h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form id="frm" method="post"  action ="{{ route('party.store') }}"  class="form-horizontal form-label-left" autocomplete="off" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label for="name">
                                    {{ trans('party.party_name') }} <span class="requride_cls">*</span>
                                </label>
                                <input type="text" id="name" name="name" class="form-control changefocus" placeholder="{{ trans('party.placeholder.party_name') }}">
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label for="mobile_no">
                                   {{ trans('party.party_mobile') }} <span class="requride_cls">*</span>
                                </label>
                                <input type="text" id="mobile_no" name="mobile_no" class="form-control numberonly changefocus" minlength="10" maxlength="10" placeholder="{{ trans('party.placeholder.party_mobile') }}">
                            </div>
                        </div>
                    </div>

                    <hr class="hrClass">

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label for="state_id">
                                    {{ trans('party.state_name') }} <span class="requride_cls">*</span>
                                </label>
                                <select class="select2 changefocus" name="state_id" id="state_id">
                                    <option value=""></option>
                                    @foreach($states as $key => $val)
                                        <option value="{{ $val->id }}">{{ $val->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label for="city_id">
                                   {{ trans('party.city_name') }} <span class="requride_cls">*</span>
                                </label>
                                <select class="select2 changefocus" name="city_id" id="city_id">
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
                                    {{ trans('party.party_add') }} <span class="requride_cls">*</span>
                                </label>
                                <textarea id="address" name="address" class="form-control changefocus" placeholder="{{ trans('party.placeholder.party_add') }}"></textarea>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label for="status">
                                    {{ trans('party.status') }} <span class="requride_cls">*</span>
                                </label>

                                <div class="radio">
                                    <label style="margin-right:20px;">
                                        <input type="radio" value="1" checked class="changefocus" name="status">{{ trans('party.active')}}
                                    </label>
                                    <label>
                                        <input type="radio" value="0" class="changefocus" name="status">{{ trans('party.deactive')}}
                                    </label>
                                </div>
                                <label id="status-error" class="error" for="status"></label>
                            </div>
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <a href=" {{ url('party') }}"><button type="button" class="btn btn-primary changefocus">{{ trans('party.btn.Cancel') }}</button></a>
                            <button type="submit" class="btn btn-success changefocus">{{ trans('party.btn.Submit') }}</button>
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

    var checkbox_index = 0;
    $('.changefocus').eq(checkbox_index).focus();
    
    $(".select2").select2({
          placeholder: "Select",
          allowClear: true,
          width:'100%'
    });

    $('body').on('focus', '.changefocus', function(e){
          var index = $('.changefocus').index(this);
          checkbox_index = index;
    });

    $('body').on('click', '.changefocus', function(e){
          var index = $('.changefocus').index(this);
    });

    $("body").on("select2-selecting", "#city_id", function(e) {
        checkbox_index = checkbox_index + 1;
        setTimeout(function() {
            $('.changefocus').eq(6).focus();
        }, 0);
    });

    $('body').on('keydown', '.changefocus', function(e){
        if (e.which == 13) {
            e.preventDefault();
            if (checkbox_index == 1) {
                checkbox_index = checkbox_index + 1;
                $(".select2:first").select2('focus');         
            } else if (checkbox_index == 8) {
                $('.changefocus').eq(10).focus();
            } else if (checkbox_index == 10) {
                $('.changefocus').eq(9).focus();
            } else if (checkbox_index == 9) {
                $('.changefocus').eq(0).focus();
            } else {
                checkbox_index = checkbox_index + 1;
                $('.changefocus').eq(checkbox_index).focus();
            }            
        }
    });

    $('body').on('change', '#state_id', function(e){
        $("#city_id").prop('disabled', true);
        var state_id = $('#state_id').val();

        if (state_id != '') {
            $.ajax({
                url:"{{ url('getStateCity') }}",
                type:'POST',
                dataType:'json',
                data:{
                    state_id:state_id
                },
                success:function(res){
                    $("#city_id").prop('disabled', false);
                    $("#city_id").val('').trigger('change');
                    $("#city_id").html('<option value=""></option>');
                    $.each(res,function(key,value) {
                        $("#city_id").append('<option value="'+key+'">'+value+'</option>');
                    });
                }
			});

        } else {
            $("#city_id").prop('disabled', false);
            $('#city_id').val('').trigger('change').html('<option value=""></option>');
        }
    });

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
            name:{ required:"{{ trans('party.message.party_name') }}" },
            mobile_no:{ required:"{{ trans('party.message.party_mobile') }}", remote: "{{ trans('party.message.mobile_remote') }}", },
            state_id:{ required:"{{ trans('party.message.state_name') }}", },
            city_id:{ required:"{{ trans('party.message.city_name') }}", },
            address:{ required:"{{ trans('party.message.party_add') }}", },
            status:{ required:"{{ trans('party.message.status') }}", },
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
