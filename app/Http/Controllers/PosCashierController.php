<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProductsModel;
use App\Models\OrdersModel;
use App\Models\OrderItemsModel;
use App\Models\TransactionsModel;
use Illuminate\Http\Request;
use DB;

class PosCashierController extends Controller {
    public function index() {
        return view('index');
    }
    
    public function newOrder() {
        return view('neworder');
    }

    public function requestRefund() {
        return view('requestrefund');
    }
    
    public function getOrders() {
        $orders = DB::table('orders')->select('reference_no', 'total_amount_cents', 'status')->where('status', '!=', 'Cancelled')->get();

        return $orders;
    }

    public function refundOrder(Request $request) {
        $referenceNo = $request->get('reference_no');

        $orderId = DB::table('orders')->select('id')->where('reference_no', $referenceNo)->first();
        $orderId = $orderId->id;
        
        DB::table('orders')->where('reference_no', $referenceNo)->update(['status' => 'Cancelled']);
        DB::table('transactions')->where('order_id', $orderId)->update(['status' => 'Refunded']);
    }

    public function getProducts() {
        $products = DB::table('products')->select('product_name', 'cost_per_item_cents')->get();

        return $products;
    }

    public function addProducts(Request $request) {
        $productName = $request->get('add_product_name');
        $productPrice = $request->get('add_product_price');

        $entity = new ProductsModel();
        $entity->product_name = $productName;
        $entity->cost_per_item_cents = $productPrice * 100;
        $entity->save();
    }

    public function checkOut(Request $request) {
        $referenceNo = $request->get('reference_no');
        $tax = $request->get('tax');
        $serviceCharge = $request->get('service_charge');
        $isWalkin = $request->get('is_walkin');
        $totalAmountInDollars = $request->get('total');
        $paymentAmountInDollars = $request->get('pay_amount');
        $paymentMethod = $request->get('payment_method');
        $arrProductName = $request->get('arr_product_name');
        $arrQuantity = $request->get('arr_quantity');

        $entityOrders = new OrdersModel();
        $entityOrders->reference_no = $referenceNo;
        $entityOrders->tax = $tax;
        $entityOrders->service_charge = $serviceCharge;
        $entityOrders->total_amount_cents = $totalAmountInDollars * 100;
        $entityOrders->is_walkin = $isWalkin;
        $entityOrders->status = 'Paid';
        $entityOrders->save();

        $orderId = DB::table('orders')->select('id')->where('reference_no', $referenceNo)->first();
        $orderId = $orderId->id;

        for($i = 0; $i < count($arrProductName); $i++) {
            $productId = DB::table('products')->select('id')->where('product_name', $arrProductName[$i])->first();
            $productId = $productId->id;
            
            $entityOrderItems = new OrderItemsModel();
            $entityOrderItems->order_id = $orderId;
            $entityOrderItems->product_id = $productId;
            $entityOrderItems->quantity = $arrQuantity[$i];
            $entityOrderItems->save();
        }

        $entityTransactions = new TransactionsModel();
        $entityTransactions->order_id = $orderId;
        $entityTransactions->payment_method = $paymentMethod;
        $entityTransactions->status = 'Paid';
        $entityTransactions->paid_amount_cents = $paymentAmountInDollars * 100;
        $entityTransactions->save();
    }
}
