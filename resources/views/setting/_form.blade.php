@extends('layouts.master')
@section('title')
{{ trans('settings.setting') }}
@endsection
@section('content')
  <!-- page content -->
  <div class="right_col" role="main">
    <div class="">

      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>{{ trans('settings.detail', [ 'module' => $moduleName ]) }}</h2>

              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <form id="frm" method="post"  action ="{{route('settings.update', $setting->id )}}"  class="form-horizontal form-label-left" autocomplete="off" enctype="multipart/form-data">
                @method('PUT')
                <input type="hidden" name="id" id="id" value="{{ $setting->id }}" />
                @csrf
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{ trans('settings.name') }} <span class="requride_cls">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="name" name="name" class="form-control changefocus" value="{{ $setting->name }}" placeholder="{{ trans('settings.placeholder.name') }}">
                  </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="logo">{{ trans('settings.logo') }} <span class="requride_cls">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="file" id="logo" name="logo" class="form-control changefocus">
                        <input type="hidden" name="old_logo" id="old_logo" value="{{ $setting->logo }}">

                          <a href="{{ url('/public/images/'.$setting->logo) }}" target="_blank"><img src="{{ url('/public/images/'.$setting->logo) }}" style="height:50px; width: 50px; margin-top: 10px;"></a>

                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="favicon">{{ trans('settings.favicon') }} <span class="requride_cls">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="file" id="favicon" name="favicon" class="form-control changefocus">
                        <input type="hidden" name="old_favicon" id="old_favicon" value="{{ $setting->favicon }}">

                        <a href="{{ url('/public/images/'.$setting->favicon) }}" target="_blank"><img src="{{ url('/public/images/'.$setting->favicon) }}" style="height:50px; width: 50px; margin-top: 10px;"></a>

                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="gst_type">
                    {{ trans('settings.gst_type') }} <span class="requride_cls">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="radio">
                            <label style="margin-right:20px;">
                            <input type="radio" value="0" {{ ($setting->gst_type == 0) ? 'checked' : '' }} class="gst_type changefocus" name="gst_type">{{ trans('settings.inter_state') }}
                            </label>
                            <label>
                            <input type="radio" value="1" {{ ($setting->gst_type == 1) ? 'checked' : '' }} class="gst_type changefocus" name="gst_type">{{ trans('settings.out_state') }}
                            </label>
                        </div>
                        <label id="gst_type-error" class="error" for="gst_type"></label>
                    </div>
                </div>

                <div class="form-group interstate" style="display:{{ ($setting->gst_type == 0) ? 'block' : 'none' }}">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cgst">
                    {{ trans('settings.cgst') }}<span class="requride_cls">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="cgst" name="cgst" class="form-control amountonly changefocus" value="{{ $setting->cgst }}" placeholder="{{ trans('settings.placeholder.cgst') }}">
                    </div>
                </div>

                <div class="form-group interstate" style="display:{{ ($setting->gst_type == 0) ? 'block' : 'none' }}">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sgst">
                    {{ trans('settings.sgst') }} <span class="requride_cls">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="sgst" name="sgst" class="form-control amountonly changefocus" value="{{ $setting->sgst }}" placeholder="{{ trans('settings.placeholder.sgst') }}">
                    </div>
                </div>

                <div class="form-group outofstate" style="display:{{ ($setting->gst_type == 1) ? 'block' : 'none' }}">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="igst">
                    {{ trans('settings.igst') }} <span class="requride_cls">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="igst" name="igst" class="form-control amountonly changefocus" value="{{ $setting->igst }}" placeholder="{{ trans('settings.placeholder.igst') }}">
                    </div>
                </div>


                <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href=" {{ url('settings') }}"><button type="button" class="btn btn-primary changefocus">{{ trans('settings.btn.Cancel') }}</button></a>
                    <button type="submit" class="btn btn-success focusClass changefocus" id="submitbtn">{{ trans('settings.btn.Submit') }}</button>
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
jQuery(document).ready(function() {

    var checkbox_index = 0;
    var state_check = 0;
    $('.changefocus').eq(checkbox_index).focus();

    $('body').on('keydown', '.changefocus', function(e){
        if (e.which == 13) {
            e.preventDefault();
            if (checkbox_index == 6 || checkbox_index == 7) {
                $('.changefocus').eq(9).focus();
            } else if (checkbox_index == 3 || checkbox_index == 4) {
                if (state_check == 0) {
                  checkbox_index = checkbox_index + 1;
                  $('.changefocus').eq(checkbox_index).focus();    
                } else {
                  $('.changefocus').eq(7).focus();    
                } 
            } else if (checkbox_index == 9) {
                $('.changefocus').eq(8).focus();
            } else if (checkbox_index == 8) {
                $('.changefocus').eq(0).focus();
            } else {
              checkbox_index = checkbox_index + 1;
              $('.changefocus').eq(checkbox_index).focus();
            } 
        }
    });

    $('body').on('change', '.gst_type', function(e){
        var val = $(this).val();
        if (val == 1) {
            state_check = 1;
        } else {
            state_check = 0;
        }
    });

    $('body').on('focus', '.changefocus', function(e){
          var index = $('.changefocus').index(this);
          checkbox_index = index;
    });

    @if (Session::has('message'))
    new PNotify({
        title: '{{ trans("settings.setting") }}',
        text: '{!! session('message') !!}',
        type: 'success',
        styling: 'bootstrap3',
        delay: 1500,
        animation: 'fade',
        animateSpeed: 'slow'
    });
    @endif

	$('body').on('click', '.gst_type', function(e){
		var gstType = $(this).val();
    if (gstType == 1) {
        $('body').find('.outofstate').show();
        $('body').find('.interstate').hide();
		} else {
        $('body').find('.outofstate').hide();
        $('body').find('.interstate').show();
		}
	});

    $('#frm').validate({
        ignore: [],
        rules:{
            name:{ required:true, },
            logo:{ extension: 'jpg|JPG|png|PNG|jpeg|JPEG', },
            favicon:{ extension: 'jpg|JPG|png|PNG|jpeg|JPEG' },
            gst_type:{ required:true, },
            cgst:{ required:true, },
            sgst:{ required:true, },
            igst:{ required:true, },
        },
        messages:
        {
            name:{ required: "{{ trans('settings.message.name') }}", },
            logo: { extension:"{{ trans('settings.message.logo') }}", },
            favicon: { extension:"{{ trans('settings.message.favicon') }}", },
            gst_type: { required: "{{ trans('settings.message.gst_type') }}", },
            cgst: { required: "{{ trans('settings.message.cgst') }}", },
            sgst: { required: "{{ trans('settings.message.sgst') }}", },
            igst: { required: "{{ trans('settings.message.igst') }}", },
        },
        submitHandler: function(form) {
            $(':input[type="submit"]').prop('disabled', true);
            form.submit();
        }
    });
});
</script>
@endsection
