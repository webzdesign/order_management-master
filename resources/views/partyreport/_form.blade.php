@extends('admin.resLayouts.master')
@section('title')
{{ $moduleName.' - '.Helper::setting()->name }}
@endsection
@section('content')
<div class="right_col" role="main">
    <div class="clearfix"></div>
    <div class="title_left">
        <a href="{{ url('admin/order-report') }}"><button class="btn btn-primary">Back</button></a>
    </div>

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
                    <h2><i class="fa fa-bars"></i> View {{$moduleName}}</h2>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <label for="date">Date 
                                    </label>
                                    <input type="text" id="date" name="date" class="form-control datepicker" placeholder="Enter Date" value="{{ date('d-m-Y', strtotime($order[0]->date)) }}" readonly>
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <label for="table_no"> Table No </label>
                                    <input type="text" id="table_no" name="table_no" class="form-control" placeholder="Table No" value="{{ $order[0]->table->name }}" readonly>
                                </div>
                            </div>
                        </div>

                        <hr class="hrClass">

                        <div class="form-group col-lg-12">
                            <table id="recipe" class="table table-bordered" cellspacing="0">
                                <thead>
                                    <tr class="success">
                                        <th>SrNo</th>
                                        <th width="20%">Category </th>
                                        <th width="20%">Item </th>
                                        <th width="15%">Item Price </th>
                                        <th width="10%">Qty </th>
                                        <th width="15%">Amount </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order as $key => $value)
                                    <tr class="orderTable">
                                        <td><label class="sr_no">{{ $key+1 }}</label></td>
                                        <td>
                                            <input type="text" id="category" name="category" class="form-control" placeholder="Category" value="{{ $value->category->name }}" readonly>
                                        </td>
                                        <td>
                                            <input type="text" id="item" name="item" class="form-control" placeholder="Item" value="{{ $value->item->name }}" readonly>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control numberonly item_price" placeholder="Price" name="item_price[]" id="item_price" readonly value="{{ $value->item_price}}"/>
                                        </td>

                                        <td>
                                            <input type="text" class="form-control numberonly qty" placeholder="Enter Qty" name="qty[]" id="qty" value="{{ $value->qty }}" readonly/>
                                        </td>

                                        <td>
                                            <input type="text" class="form-control numberonly amount" placeholder="Amount" name="amount[]" id="amount" readonly value = "{{$value->amount}}">
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="5" style="text-align:right;">Grand Total:</td>
                                        <td><input type="text" class="form-control numberonly grand_total" placeholder="Grand Total" name="grand_total" id="grand_total" readonly value="{{$order[0]->grand_total}}"/></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="ln_solid"></div>

                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">
                                <a href="{{ url('admin/order-report') }}" class="btn btn-primary">Cancel</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
jQuery(document).ready(function() {
    
});
</script>
@endsection
