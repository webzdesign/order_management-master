@extends('layouts.master')
@section('title')
{{ $moduleName.' - '.Helper::setting()->name }}
@endsection
@section('content')

<div class="right_col" role="main">
    <div class="clearfix"></div>
    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                        <h2><i class="fa fa-bars"></i> {{$moduleName }} Details</h2>
                        <div class="clearfix"></div>
                </div>

                <form action="{{ url('printCitywiseReport')}}" method="post" target="_blank" name="form">
                @csrf

                <div class="form-group">
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <label for="state">State <span class="requride_cls">*</span>
                        </label>
                    
                        <select id="state" name="state" class="form-control select2_single">
                            <option></option>
                            @foreach ($state as $state)
                                <option {{ (old('state')== $state->id)?'selected':'' }} value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <label for="city">City <span class="requride_cls">*</span>
                        </label>
                        <select id="city" name="city" class="form-control select2_single">
                            <option></option>
                        </select>
                    </div>

                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <label for="from">From Date 
                            </label>
                                <input type="text" id="from" name="from"  class="form-control col-md-7 col-xs-12 focusClass " placeholder="Select From Date" value="{{ date('d-m-Y')}}" readonly>
                            <div id="fromerror">
                            </div>
                        </div>
                
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <label for="to">To Date
                            </label>
                                <input type="text" id="to" name="to"  class="form-control col-md-7 col-xs-12 focusClass " placeholder="Select To Date" value="{{ date('d-m-Y')}}" readonly>
                            <div id="toerror">
                            </div>
                        </div>
                
                    <div class="col-md-4 col-sm-4 col-xs-12" style="margin-top:2%;">
                        <button type="submit" class="btn btn-success searchData"><i class="fa fa-search"></i> Search</button>
                        <button class="btn btn-danger searchClear"><i class="fa fa-close"></i> Clear</button>
                        <button class="btn btn-primary printData" type="submit"><i class="fa fa-print"></i> Print</button>
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
                                    <th>SrNo</th>
                                    <th>Party</th>
                                    <th>Orde No</th>
                                    <th>Order Date</th>
                                    <th>Order Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
		                        <tr>
                                    <th colspan="4"></th><th></th>
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

    var from = $('#from').val();
    var to = $('#to').val();

    $('#state').on('change', function(){
        $("#city").prop('disabled', true);
        var state_id = $('#state').val();

        if (state_id != '') {
            $.ajax({
                url:"{{ url('getReportStateCity') }}",
                type:'POST',
                dataType:'json',
                data:{
                    state_id:state_id
                },
                success:function(res){
                    $("#city").prop('disabled', false);
                    $("#city").val('').trigger('change');
                    $("#city").html('<option value=""></option>');
                    $.each(res,function(key,value) {
                        $("#city").append('<option value="'+key+'">'+value+'</option>');
                    });
                }
			});
        } else {
            $("#city").prop('disabled', false);
            $('#city').val('').trigger('change').html('<option value=""></option>');
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

    @if (Session::has('message'))
    new PNotify({
        title: '{{ $moduleName }}',
        text: '{!! session('message') !!}',
        type: 'success',
        styling: 'bootstrap3',
        delay: 1500,
        animation: 'fade',
        animateSpeed: 'slow'
    });
    @endif

    var datatable = $('.datatable').DataTable({
        processing: true,
        serverSide: true,
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
            $(api.column(0).footer()).html('GRAND TOTAL');
            $(api.column(4).footer()).html(amountTotal.toLocaleString('en-US', { style: 'currency', currency: 'INR' }));
        },
        ajax: {
            "url": "{{ url('getCitywiseReportData') }}",
			"dataType": "json",
            "type": "get",
            data: {
                state:function(){
                    return $("#state").val();
                },
                city:function(){
                    return $("#city").val();
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
            { data: 'grand_total'},
        ],
    });
    
    $('.searchData').on('click', function(e) {
        e.preventDefault();
        datatable.draw();
    });

    $('.searchClear').on('click', function(e) {
        e.preventDefault();
        $('#state').val('').trigger('change');
        $('#city').val('').trigger('change');
        $('#from').val(from);
        $('#to').val(to);
        datatable.draw();
    });
    
});
</script>
@endsection
