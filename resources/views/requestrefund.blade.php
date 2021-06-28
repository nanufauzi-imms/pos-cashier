<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>POS - Cashier</title>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
        <style>
            body {
                width: 100%;
                overflow-x: hidden;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row text-center">
                <div class="col-md-12">
                    <h3 class="p-3">Request for Refund</h3>
                    <table id="orders" width="100%">
                        <tr id="order">
                            <th width="5%">No.</th>
                            <th width="30%">Reference No.</th>
                            <th width="20%">Amount (RM)</th>
                            <th width="20%">Status</th>
                            {{ csrf_field() }}
                            <th width="25%">Request for Refund</th>
                        </tr>
                    </table><br>
                    <button type="submit" class="btn btn-secondary m-3" onclick="location.href = '{{ route('index') }}'" style="width: 300px;">Cancel</button>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                getOrders();
            });

            function getOrders() {
                var j = 1;

                $.ajax({
                    url: "{{ route('getOrders') }}",
                    type: "GET",
                    success: function(results) {
                        jQuery.each(results, function(i, value) {
                            var reference_no = JSON.stringify(value.reference_no);
                            reference_no = reference_no.replace(/\"/g, "");
                            var total_amount_cents = JSON.stringify(value.total_amount_cents);
                            var status = JSON.stringify(value.status);
                            status = status.replace(/\"/g, "");
                            var total_amount_dollars = (total_amount_cents / 100).toFixed(2);

                            var orders = $('#orders');

                            $('<tr><td>' + j + '</td>' + '<td>' + reference_no + '</td>' + '<td>' + total_amount_dollars + '</td>' + '<td>' + status + '</td>' + '<td><button class="btn btn-warning requestRefundButton" value="' + reference_no + '">' + 'Request' + '</td></tr>').appendTo(orders);
                            j++;
                        });

                        $('.requestRefundButton').click(function(){
                            var reference_no = $(this).val();
                            var _token = $('input[name="_token"]').val();

                            $.ajax({
                                url: "{{ route('refundOrder') }}",
                                method: "POST",
                                data: {reference_no: reference_no, _token: _token},
                                success: function(result)
                                {
                                    alert("Refund successful!");
                                    window.location.href = "{{ route('index') }}";
                                }
                            })
                        });
                    }
                });
            }
        </script>
    </body>
</html>