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
                <div class="col-md-6">
                    <h3 class="p-3">POS<br>Cashier</h3>
                    <p class="text-left"><b>Reference Number:</b> <span id="referenceNo" value="{{ 'IN'.date('dmYhis') }}">{{ 'IN'.date('dmYhis') }}</span></p>
                    <div id="cart">
                        <table id="cartItems" width="100%">
                            <tr>
                                <th width="25%">Product</th>
                                <th width="25%">Price (RM)</th>
                                <th width="25%">Quantity</th>
                                <th width="25%">Cost (RM)</th>
                            </tr>
                        </table><br>
                        <div class="row">
                            <div class="col-md-6 text-left">Subtotal</div>
                            <div class="col-md-6 text-right">RM<span id="subtotal">0</span></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-left">No. of Items</div>
                            <div class="col-md-6 text-right" id="noOfItems">0</div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-left">Tax</div>
                            <div class="col-md-6 text-right" id="tax" value="0">0</div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-left">Service Charge</div>
                            <div class="col-md-6 text-right"><span id="serviceCharge" value="6">6</span>%</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 text-left">Total</div>
                            <div class="col-md-6 text-right">RM<span class="total">0</span></div>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-secondary m-3" onclick="location.href = '{{ route('index') }}'" style="width: 300px;">Cancel</button>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-primary m-3" data-toggle="modal" data-target="#checkOutModal" style="width: 300px;">Check Out</button>

                            <div class="modal fade" id="checkOutModal" tabindex="-1" role="dialog" aria-labelledby="checkOutModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content text-left">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="checkOutModalLabel">Check Out</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            {{ csrf_field() }}
                                            <input type="hidden" id="isWalkin" value="1">
                                            <p><b>Total: </b>RM<span id="total" class="total">0</span></p>
                                            <div class="form-group">
                                                <label for="payAmount">Enter Pay Amount (RM)</label>
                                                <input type="number" id="payAmount" step="0.01" min="0" class="form-control col-md-12" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="paymentMethod">Select Payment Method</label>
                                                <select id="paymentMethod" class="form-control col-md-12" required>
                                                    <option value="cash">Cash</option>
                                                </select>
                                                <p>*Only cash payment method is available at the moment.</p>
                                            </div>
                                            <p><b>Balance: </b><span id="balance"></span></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" id="closecheckOutModal" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" id="checkOut" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <h3 class="p-3">Products</h3>
                    <h5 class="p-3">Click on product to add to cart.</h5>
                    <div id="products" class="row pb-3"></div>

                    <button type="button" class="btn btn-primary m-3" data-toggle="modal" data-target="#addProductModal" style="width: 200px;">Add Product</button>

                    <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content text-left">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <p>Enter Product Info:</p>
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="addProductName">Product Name</label>
                                        <input type="text" id="addProductName" class="form-control col-md-12">
                                        <p>*No special characters allowed at the moment.</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="addProductPrice">Product Price (RM)</label>
                                        <input type="number" id="addProductPrice" step="0.01" min="0" class="form-control col-md-12">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="closeAddProductModal" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="button" id="addProduct" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            var arr_product_name = [];
            var arr_quantity = [];

            $(document).ready(function() {
                getProducts();
            });

            $('.modal').on('hidden.bs.modal', function() {
                $('#payAmount').val('');
                $('#balance').html('');
                $('#addProductName').val('');
                $('#addProductPrice').val('');
            });

            $('#addProduct').click(function() {
                if($('#addProductName').val() != '' && $('#addProductPrice').val() != '') {
                    var add_product_name = $('#addProductName').val();
                    var add_product_price = $('#addProductPrice').val();
                    var _token = $('input[name="_token"]').val();

                    $.ajax({
                        url: "{{ route('addProducts') }}",
                        method: "POST",
                        data: {add_product_name: add_product_name, add_product_price: add_product_price, _token: _token},
                        success: function()
                        {
                            alert("Product successfully added!");
                            getProducts();
                        }
                    })
                }
                add_product_name = $('#addProductName').val('');
                add_product_price = $('#addProductPrice').val('');
                $('#closeAddProductModal').click();
            });

            $("#cartItems").on('update change', function () {
                var cost = 0;
                var no_of_items = 0;
                var total = 0;

                $('#subtotal').html('');
                $('#noOfItems').html('');
                $('.total').html('');

                $(function() {
                    arr_product_name = [];
                    $('.productName').each(function() {
                        arr_product_name.push($(this).html());
                    });
                });
                
                $(function() {
                    $('.cost').each(function() {
                        cost += parseFloat($(this).html());
                    });
                    $('#subtotal').html(cost.toFixed(2));
                    total = (cost * 1.06).toFixed(2);
                    $('.total').html(total);
                    $('#total').attr('value', total);
                });

                $(function() {
                    arr_quantity = [];
                    $('.quantity').each(function() {
                        no_of_items += parseInt($(this).val());
                        arr_quantity.push($(this).val());
                    });
                    $('#noOfItems').html(no_of_items);
                });
            });

            $('#payAmount').change(function() {
                var payAmount = $(this).val();
                var total = $('#total').attr('value');
                var balance = (payAmount - total).toFixed(2);

                $('#balance').html('');

                if(balance >= 0) {
                    $('#balance').html('RM' + balance);
                }
                else {
                    $('#balance').html('Insufficient pay amount entered!');
                }
            });

            $('#checkOut').click(function() {
                if($('#payAmount').val() != '' && $('#paymentMethod').val() != '' && ($('#payAmount').val() >= $('#total').attr('value'))) {
                    var reference_no = $('#referenceNo').attr('value');
                    var tax = $('#tax').attr('value');
                    var service_charge = $('#serviceCharge').attr('value');
                    var is_walkin = $('#isWalkin').attr('value');
                    var total = $('#total').attr('value');
                    var pay_amount = $('#payAmount').val();
                    var payment_method = $('#paymentMethod').val();
                    var _token = $('input[name="_token"]').val();

                    $.ajax({
                        url: "{{ route('checkOut') }}",
                        method: "POST",
                        data: {reference_no: reference_no, tax: tax, service_charge: service_charge, is_walkin: is_walkin, total: total, pay_amount: pay_amount, payment_method: payment_method, _token: _token, arr_product_name: arr_product_name, arr_quantity: arr_quantity},
                        success: function()
                        {
                            alert("Success!");
                            window.location.href = "{{ route('index') }}";
                        }
                    })
                }
            });

            function getProducts() {
                $.ajax({
                    url: "{{ route('getProducts') }}",
                    type: "GET",
                    success: function(results) {
                        $('#products').html('');
                        jQuery.each(results, function(i, value) {
                            var product_name = JSON.stringify(value.product_name);
                            product_name = product_name.replace(/\"/g, "");
                            var cost_per_item_cents = JSON.stringify(value.cost_per_item_cents);
                            var cost_per_item_dollars = (cost_per_item_cents / 100).toFixed(2);

                            var products = $('#products');
                            var product_info = product_name + ', ' + cost_per_item_dollars;

                            $('<button class="' + 'col-md-6 p-3" style="background-color: #fff; border: 1px solid #000;">' + product_name + '<br>' + 'RM' + cost_per_item_dollars + '</button>').appendTo(products).attr('value', product_info).addClass('productButton');
                        });

                        $('.productButton').click(function(){
                            var product_info = $(this).val();

                            addItem(product_info);
                            $('#cartItems').trigger('update');
                        });
                    }
                });
            }

            function addItem(product_info) {
                var split_product_info = product_info.split(', ');
                var product_name = split_product_info[0];
                var cost_per_item_dollars = split_product_info[1];
                
                if(jQuery.inArray(product_name, arr_product_name) !== -1) {
                    alert('Item already in cart!');
                }
                else {
                    $('#cartItems tr:last').after('<tr><td class="productName" value="' + product_name + '">' + product_name + '</td>' + '<td>' + cost_per_item_dollars + '</td>' + '<td>' + '<input type="number" min="0" value="1" class="col-md-6 quantity">' + '</td>' + '<td class="cost" value="' + cost_per_item_dollars + '">' + cost_per_item_dollars + '</td></tr>');
                }

                $('.quantity').change(function() {
                    var quantity = $(this).val();
                    var cost = $(this).closest('td').next().attr('value');

                    $(this).closest('td').next().text((quantity * cost).toFixed(2));

                    if(quantity == 0) {
                        $(this).closest('tr').remove();
                    }
                });
            }
        </script>
    </body>
</html>