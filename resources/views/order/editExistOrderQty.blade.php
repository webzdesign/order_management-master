@if (! $orderDetail->isEmpty())
@php $cnt = 0; @endphp
@foreach($orderDetail as $k => $v)
<tr>
    <td><label class="sr_no_modal">{{ $k+1 }} </label></td>
    <td>
        <input type="hidden" name="orderId[]" id="orderId" value="{{ $cnt }}" />
        <select name="remaining_product[]" id="remaining_product" class="form-control select2_single remaining_product" style="width:100%;" disabled>
            <option =""></option>
            @foreach($product as $key => $value)
            <option value="{{$value->id}}" {{ ($value->id == $v->product_id) ? 'selected' : '' }} >{{$value->name}}</option>
            @endforeach
        </select>
    </td>
    <td>
        <input type="text" class="form-control remaining_qty" placeholder="Enter Remaining Qty" name="remaining_qty[]" id="remaining_qty" value="{{ $v->remaining_qty }}" readonly>
    </td>
    <td>
        <input type="text" class="form-control dispatch_qty" placeholder="Enter Dispatch Qty" name="dispatch_qty[]" id="dispatch_qty" >
    </td>
</tr>
@php $cnt++; @endphp
@endforeach
@endif
