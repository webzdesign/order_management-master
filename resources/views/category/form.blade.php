@extends('layouts.master')
@section('title')
{{$moduleName}} - {{ Helper::setting()->name }}
@endsection
@section('content')
<!-- page content -->
<div class="right_col" role="main">
    <div class="title_left">
        <a href="{{ url('category') }}"><button class="btn btn-primary" >{{ trans('category.btn.Back') }}</button></a>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
            <div class="x_title">
                <h2>{{ trans('category.add', [ 'module' => $moduleName ]) }}</h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form id="frm" method="post"  action ="{{route('category.store')}}"  class="form-horizontal form-label-left" autocomplete="off" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                            {{ trans('category.cat_name') }}<span class="requride_cls">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="name" name="name"  class="form-control col-md-7 col-xs-12 changefocus" placeholder="{{ trans('category.placeholder.cat_name') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">
                            {{ trans('category.image') }}
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="file" id="image" name="image"  class="form-control col-md-7 col-xs-12 changefocus">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">
                            {{ trans('category.status') }}<span class="requride_cls">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="radio">
                            <label style="margin-right:4%;">
                                <input type="radio" class="status changefocus" checked id="status" name="status" value="1">{{ trans('category.active')}}
                            </label>
                            <label style="margin-right:4%;">
                                <input type="radio" class="status changefocus" id="status" name="status" value="2">{{ trans('category.deactive')}}
                            </label>
                        </div>
                        </div>
                        <label id="status-error" class="error requride_cls" for="status"></label>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <a href=" {{ url('category') }}"><button type="button" class="btn btn-primary changefocus">{{ trans('category.btn.Cancel') }}</button></a>
                            <button type="submit" class="btn btn-success changefocus">{{ trans('category.btn.Submit') }}</button>
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
    $('body').on('focus', '.changefocus', function(e){
          var index = $('.changefocus').index(this);
          checkbox_index = index;
    });

    $('body').on('keydown', '.changefocus', function(e){
          if (e.which == 13) {
            e.preventDefault();
            if (checkbox_index == 3) {
                $('.changefocus').eq(5).focus();
            } else if (checkbox_index == 5) {
                $('.changefocus').eq(4).focus();
            } else if (checkbox_index == 4) {
                $('.changefocus').eq(0).focus();
            } else {
                checkbox_index = checkbox_index + 1;
                $('.changefocus').eq(checkbox_index).focus();
            }
            
          }
    });

    $('#frm').validate({
        rules:{
            name:{
                required:true,
                remote:{
                    type:'POST',
                    url:"{{ url('checkCategoryName') }}",
                    data:{
                        name:function(){
                            return $("#name").val();
                        },
                    },
                },
            },
            image:{
                extension: 'jpg|JPG|png|PNG|jpeg|JPEG',
            },
            status:{ required:true, },
        },
        messages:
        {
            name:{ required:"{{ trans('category.message.cat_name') }}", remote: "{{ trans('category.message.cat_remote') }}", },
            image:{
                extension:"{{ trans('category.message.image_check') }}",
            },
            status:{ required:"{{ trans('category.message.status') }}", },
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
