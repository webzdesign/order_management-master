@extends('layouts.master')
@section('title')
{{ trans('productwisereport.detail', [ 'module' => $moduleName ]).' - '.Helper::setting()->name }}
@endsection
@section('content')

<div class="right_col" role="main">
    <div class="clearfix"></div>
    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                        <h2><i class="fa fa-bars"></i> {{ trans('productwisereport.detail', [ 'module' => $moduleName ]) }}</h2>
                        <div class="clearfix"></div>
                </div>

                <form action="{{ url('printProductwiseReport')}}" method="post" target="_blank" name="form">
                @csrf

                <div class="form-group">
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <label for="category"> {{ trans('productwisereport.category') }} <span class="requride_cls">*</span>
                        </label>
                    
                        <select id="category" name="category" class="select2">
                            <option></option>
                            @foreach ($category as $category)
                            <option {{ (old('category')== $category->id)?'selected':'' }} value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <label for="product">{{ trans('productwisereport.product') }}  <span class="requride_cls">*</span>
                        </label>
                    
                        <select id="product" name="product" class="select2">
                            <option></option>
                        </select>
                    </div>

                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <label for="from">{{ trans('productwisereport.from_date') }}
                            </label>
                                <input type="text" id="from" name="from"  class="form-control col-md-7 col-xs-12 focusClass " placeholder="Select From Date" value="{{ date('d-m-Y')}}" readonly>
                            <div id="fromerror">
                            </div>
                        </div>
                
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <label for="to">{{ trans('productwisereport.to_date') }}
                            </label>
                                <input type="text" id="to" name="to"  class="form-control col-md-7 col-xs-12 focusClass " placeholder="Select To Date" value="{{ date('d-m-Y')}}" readonly>
                            <div id="toerror">
                            </div>
                        </div>
                
                    <div class="col-md-4 col-sm-4 col-xs-12" style="margin-top:2%;">
                        <button type="submit" class="btn btn-success searchData"><i class="fa fa-search"></i>{{ trans('productwisereport.btn.Search') }} </button>
                        <button class="btn btn-danger searchClear"><i class="fa fa-close"></i> {{ trans('productwisereport.btn.Clear') }}</button>
                        <button class="btn btn-primary printData" type="submit"><i class="fa fa-print"></i> {{ trans('productwisereport.btn.Print') }}</button>
                    </div>
                </div>
                </form>
                <div class="row"></div><hr>
                <div class="x_content">
                    <div class="card-box table-responsive">
                        <table class="datatable mdl-data-table dataTable table table-striped table-bordered" cellspacing="0"
                        width="100%" role="grid" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>{{ trans('productwisereport.tfield.sr_no') }}</th>
                                    <th>{{ trans('productwisereport.tfield.party') }}</th>
                                    <th>{{ trans('productwisereport.tfield.order_no') }}</th>
                                    <th>{{ trans('productwisereport.tfield.order_date') }}</th>
                                    <th>{{ trans('productwisereport.tfield.product_amount') }}</th>
                                    <th>{{ trans('productwisereport.tfield.order_amount') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
		                        <tr>
                                    <th colspan="5"></th><th></th>
                                </tr>
	                        </tfoot>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>
</div>

@endsection
@section('script')
<script>
$(document).ready(function() {

    $(".select2").select2({
          placeholder: "Select",
          allowClear: true,
          width:'100%'
    });

    var lang_url = "";
    var lang_type  = "{{ Session::get('locale')}}";
    if (lang_type == 'en') {
        lang_url = "{{ url('/resources/lang/en/datatable_en.json') }}";
    } else {
        lang_url = "{{ url('/resources/lang/gu/datatable_gj.json') }}";
    }
    var from = $('#from').val();
    var to = $('#to').val();

    $('#category').on('change', function(){
        $("#product").prop('disabled', true);
        var category_id = $('#category').val();

        if (category_id != '') {
            $.ajax({
                url:"{{ url('getCategoryProduct') }}",
                type:'POST',
                dataType:'json',
                data:{
                    category_id:category_id
                },
                success:function(res){
                    $("#product").prop('disabled', false);
                    $("#product").val('').trigger('change');
                    $("#product").html('<option value=""></option>');
                    $.each(res,function(key,value) {
                        $("#product").append('<option value="'+key+'">'+value+'</option>');
                    });
                }
			});

        } else {
            $("#product").prop('disabled', false);
            $('#product').val('').trigger('change').html('<option value=""></option>');
        }
    })
    
    $('#from').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'dd-mm-yyyy',
    })
    .on('changeDate', function(selected){
        var minDate = new Date(selected.date.valueOf());
        $('#to').datepicker('setStartDate', minDate);
    });

    $('#to').datepicker({
            autoclose: true,
            todayHighlight: true,
        format: 'dd-mm-yyyy',
    })
    .on('changeDate', function(selected){
        var maxDate = new Date(selected.date.valueOf());
        $('#from').datepicker('setEndDate', maxDate);
    });

    var datatable = $('.datatable').DataTable({
        processing: true,
        serverSide: true,
        "language": {
              "url": lang_url
        },
        paging: false,
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.substring(0).replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
            var amountTotal = api.column(4).data().reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            $(api.column(0).footer()).css("text-align", "right");
            $(api.column(0).footer()).html("{{ trans('productwisereport.grand_total') }}");
            // $(api.column(5).footer()).html(amountTotal.toLocaleString('en-US', { style: 'currency', currency: 'INR' }));
            $(api.column(5).footer()).html(amountTotal.toLocaleString('en-IN'));
        },
        ajax: {
            "url": "{{ url('getProductwiseReportData') }}",
			"dataType": "json",
            "type": "get",
            data: {
                category:function(){
                    return $("#category").val();
                },
                product:function(){
                    return $("#product").val();
                },
                from:function(){
                    return $('#from').val();
                },
                to:function(){
                    return $('#to').val();
                },
            }
        },
        columns: [
            { data: 'DT_RowIndex', searchable: false, orderable: false},
            { data: 'party.name'},
            { data: 'order_no'},
            { data: 'date'},
            { data: 'amount'},
            { data: 'grand_total'},
        ],
    });
    
    $('.searchData').on('click', function(e) {
        e.preventDefault();
        datatable.draw();
    });

    $('.searchClear').on('click', function(e) {
        e.preventDefault();
        $("#category").select2("val", "");
        $("#product").select2("val", "").empty();
        $('#from').val(from);
        $('#to').val(to);
        datatable.draw();
    });
    
});
</script>
@endsection
