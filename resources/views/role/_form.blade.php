@extends('layouts.master')
@section('title')
{{ trans('role.detail', [ 'module' => $moduleName ]).' - '.Helper::setting()->name  }}
@endsection
@section('content')
<!-- page content -->
<style>
    .permissionHeader{
        color:black;
        border-style: outset;
        font-weight: bold;
        background-color:#bbe7ff;
    }
    .selectalltitle{
        color:#3e1ad0;
        margin-right:10px;
    }
    .deselectalltitle{
        color:#e8182b;
        margin-right:10px;
    }
    .permissionOption{
        color: black;
        font-size: 13px;
    }
</style>
<div class="right_col" role="main">
    <div class="title_left">
        <a href="{{url('role')}}"><button class="btn btn-primary" >{{ trans('role.btn.Back') }}</button></a>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-bars"></i>{{ trans('role.edit', [ 'module' => $moduleName ]) }}</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form id="form" method="post"  action ="{{route('role.update', $role->id)}}"  class="form-horizontal form-label-left" autocomplete="off" enctype="multipart/form-data">

                        @method('PUT')
                        <input type="hidden" id="id" name="id" value="{{$role->id}}" />
                        @csrf

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                                {{ trans('role.role_name') }} <span class="requride_cls">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="name" name="name" class="form-control col-md-7 col-xs-12" placeholder="{{ trans('role.placeholder.role_name') }}" value="{{ $role->name }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">
                                {{ trans('role.role_description') }}
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea id="description" name="description" class="form-control col-md-7 col-xs-12" placeholder="{{ trans('role.placeholder.role_description') }}" rows="3">{{ $role->description }}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name">{{ trans('role.permissions') }} :</label>

                            <div class="col-lg-12 permission-card">
                            @php $cnt = 1; @endphp
                            @foreach($permissions as $k=>$permission)
                                @if($cnt%3 == 1)
                                    <div class="row">
                                @endif
                                    <div class="col-lg-4 permission-listing">
                                        <div class="permissionHeader">{{ $k }} <a class="pull-right selectDeselect deselectalltitle" value="deselect">Deselect All</a> <a class="pull-right selectDeselect selectalltitle" value="select">Select All</a></div>
                                        @foreach($permission as $key=>$val)
                                        <div class="checkbox">
                                            <label class="permissionOption"><input type="checkbox" class="permission-options permission" name="permission[]" @if(in_array($val->id,$existPermission)) checked @endif value="{{ $val->id }}"> {{ $val->name }} </label>
                                        </div>
                                        @endforeach
                                    </div>
                                @if($cnt%3 == 0)
                                    </div>
                                    <hr class="form-part">
                                @endif
                                @php $cnt++; @endphp
                            @endforeach
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-4">
                                <a href=" {{ url('role') }}" class="btn btn-primary">{{ trans('role.btn.Cancel') }}</a>
                                <button type="submit" id="submitButton" class="btn btn-success focusClass">{{ trans('role.btn.Submit') }}</button>
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

    $('body').on('click','.selectDeselect',function(e){
        var selectVal = $(this).attr('value');
        if(selectVal == 'select'){
            $(this).closest('.permission-listing').find(".permission").prop("checked", true);
        }else{
            $(this).closest('.permission-listing').find(".permission").prop("checked", false);
        }
    });

    $('#form').validate({
        rules:{
            name: {
                required: true,
                remote:{
                    type:'POST',
                    url:"{{url('checkRoleName')}}",
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
        },
        messages:
        {
            name: { required: "{{ trans('role.message.role_name') }}", remote:"{{ trans('role.message.role_remote') }}", },
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
