@extends('layouts.master')
@section('title')
{{$moduleName}}
@endsection
@section('content')
  <!-- page content -->
  <div class="right_col" role="main">
    <div class="">

      <div class="clearfix"></div>
      <div class="row">
      @if (Session::has('message'))
      <div class="alert alert-success">
          <button type="button" class="close" data-dismiss="alert">
              <i class="ace-icon fa fa-times"></i>
          </button>
              {!! session('message') !!}
      </div>
      @endif
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>{{$moduleName}}</h2>

              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <br />
              <form id="frm" method="post"  action ="{{route('settings.update', $setting->id )}}"  class="form-horizontal form-label-left" autocomplete="off" enctype="multipart/form-data">
                @method('PUT')
                <input type="hidden" name="id" id="id" value="{{ $setting->id }}" />
                @csrf
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="requride_cls">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="name" name="name" class="form-control" value="{{ $setting->name }}" placeholder="Enter Name">
                  </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="logo">Logo <span class="requride_cls">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="file" id="logo" name="logo" class="form-control">
                        <input type="hidden" name="old_logo" id="old_logo" value="{{ $setting->logo }}">

                          <a href="{{ url('/public/images/'.$setting->logo) }}" target="_blank"><img src="{{ url('/public/images/'.$setting->logo) }}" style="height:50px; width: 50px; margin-top: 10px;"></a>

                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="favicon">Favicon <span class="requride_cls">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="file" id="favicon" name="favicon" class="form-control">
                        <input type="hidden" name="old_favicon" id="old_favicon" value="{{ $setting->favicon }}">

                          <a href="{{ url('/public/images/'.$setting->favicon) }}" target="_blank"><img src="{{ url('/public/images/'.$setting->favicon) }}" style="height:50px; width: 50px; margin-top: 10px;"></a>

                    </div>
                </div>



                <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href=" {{ url('admin/settings') }}" class="btn btn-primary">Cancel</a>
                    <button type="submit" class="btn btn-success focusClass" id="submitbtn">Submit</button>
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
    $('#frm').validate({
      ignore: [],
        rules:{
          name:{
            required:true,
          },
          logo:{
              extension: 'jpg|JPG|png|PNG|jpeg|JPEG'
          },
          favicon:{
              extension: 'jpg|JPG|png|PNG|jpeg|JPEG'
          }
        },
        messages:
        {
          name:{ required: "Enter Name", },
          logo: { extension:"Only JPG / PNG / JPEG Format Allowed.", },
          favicon: { extension:"Only JPG / PNG / JPEG Format Allowed.", },

        },
        submitHandler: function(form) {
            $(':input[type="submit"]').prop('disabled', true);
            form.submit();
        }
    });

});
</script>
@endsection
