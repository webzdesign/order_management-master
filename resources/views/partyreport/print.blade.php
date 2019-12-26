<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Inventory Stock Report</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            @page {
                margin: 35px;
            }

            header {
                position: fixed;
                top: -80px;
                left: 0px;
                right: 0px;
                height: 100px;
                text-align: center;
                line-height: 30px;
            }

            footer {
                position: fixed;
                bottom: -80px;
                left: 0px;
                right: 0px;
                height: 40px;

                background-color: #e2e2e2;
                text-align: center;
                line-height: 35px;
            }
            .trClass{
                font-size:13px;
                font-weight:bold;
                text-align: center;
                font-size: 18px;
            }
            .tbodyCss{
                text-align: center;
                font-size: 16px;
            }
            .headerimage{
                width:90px;
                height:90px;
            }
            .amount{
                text-align: right;
                padding-right:50px;
            }
            .grandamount{
                text-align: right;
                padding-right:48px;
                font-size: 18px;
                font-weight:bold;
            }
            .header-text{
                padding-left:10px;
            }
            table tr th.no-border-left, table tr td.no-border-left
            {
              border-left:none !important;
            }
            table tr th.no-border-right, table tr td.no-border-right
            {
              border-right:none !important;
            }
            table tr th.border-top, table tr td.border-top
            {
                border-top:1px solid rgb(0,0,0) !important;
            }
            table tr th.border-bottom, table tr td.border-bottom
            {
                border-bottom:1px solid rgb(0,0,0) !important;
            }

        </style>
    </head>

    <body>
        <main>
            <table class="table" width="100%" border="1" style="border-collapse:collapse;">
                <thead>
                    <tr class="trClass">
                        <th width="5%">No</th>
                        <th width="20%">Category</th>
                        <th width="20%">Item</th>
                        <th width="20%">Stock In</th>
                        <th width="20%">Stock Out</th>
                        <th width="15%">Available Stock</th>
                    </tr>
                </thead>

                <tbody class="tbodyCss">
                    @foreach($inventorystock as $key => $val)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$val->stockcategory->name}}</td>
                        <td>{{$val->name}}</td>
                        <td>{{$val->qty}}</td>
                        <td>{{ Helper::getStockOut($val->stock_category_id, $val->id) }}</td>
                        <td>{{ ($val->qty - Helper::getStockOut($val->stockcategory->id, $val->id)) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                
            </table>
        </main>
    </body>
</html>
