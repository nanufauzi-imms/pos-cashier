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
                overflow: hidden;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid" style="height: 100vh;">
            <div class="row align-items-center text-center" style="height: 100vh;">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary" onclick="location.href = '{{ route('newOrder') }}'" style="width: 600px; height: 400px; font-size: 100px;">New Order</button>
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary" onclick="location.href = '{{ route('requestRefund') }}'" style="width: 600px; height: 400px; font-size: 100px;">Request for Refund</button>
                </div>
            </div>
        </div>
    </body>
</html>