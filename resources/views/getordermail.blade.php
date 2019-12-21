<html>
  <head>
    <title>Order Place</title>
  </head>
  <body>
    <h3>{{$subject}}</h3>
    Hello,   <br/>
    <p style="font:size:13px;">Your {{$description}}</p>

    <span style="font-size:15px;">OrderNo : </span> <span style="color:DarkCyan">{{$order}}</span><br/>
    <span style="font-size:15px;">Dealer Name : </span> <span style="color:DarkCyan">{{$dealer}}</span><br/>
    <span style="font-size:15px;">City Name : </span> <span style="color:DarkCyan">{{$order_detail[0]->city->name}}</span><br/>
    <span style="font-size:15px;">Date : </span> <span style="color:DarkCyan">{{date("d-m-Y", strtotime($date))}}</span><br/>
		<span style="font-size:15px;">Salesman Name : </span> <span style="color:DarkCyan">{{$order_detail[0]->user->name}}</span><br/>
		<span style="font-size:15px;">Remarks : </span> <span style="color:DarkCyan">{{$order_detail[0]->instruction}}</span><br/>
		<span style="font-size:15px;">Transporter : </span> <span style="color:DarkCyan">{{$order_detail[0]->transporter}}</span><br/>

	<table width ="70%" border= "1px solid black;">
	<thead>
		<tr>
		<th>Sr No</th>
		<th>Product</th>
		<th>Qty</th>
		</tr>
	</thead>
	<tbody>

		@foreach($order_detail as $key => $value)
		<tr>
		<td>{{$key+1}}</td>
		<td>{{$value->product->name}}</td>
		<td>{{$value->qty}}</td>
		</tr>
		@endforeach
	</tbody>
	</table>

  </body>
</html>