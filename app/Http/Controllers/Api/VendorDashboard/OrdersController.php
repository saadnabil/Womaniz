<?php
namespace App\Http\Controllers\Api\VendorDashboard;
use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\OrderResource;
use App\Http\Resources\Dashboard\OrderTableResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Order;
class OrdersController extends Controller
{
    use ApiResponseTrait;
    public function index(){
        $orders = Order::with('user','orderDetails.product')->latest()->get();
        dd($orders);




        if(request()->has('status')){
            $orders = $orders->where('status', request('status'));
        }
        if(request()->has('search')){
            $orders = $orders->where(function($query){
                $query->where('id', 'like', '%'.request('search').'%')
                      ->orWhere('status', 'like', '%'.request('search').'%')
                      ->orWhere('payment_method', 'like', '%'.request('search').'%')
                      ->orWhere('total', 'like', '%'.request('search').'%')
                      ->orWhere('totalsub', 'like', '%'.request('search').'%')
                      ->orWhere('discount', 'like', '%'.request('search').'%')
                      ->orWhere('vat', 'like', '%'.request('search').'%')
                      ->orWhere('shipping', 'like', '%'.request('search').'%')
                      ->orWhereHas('address',function($q){
                            $q->where('long', 'like', '%'.request('search').'%')
                              ->orWhere('lat' , 'like', '%'.request('search').'%')
                              ->orWhere('label' , 'like', '%'.request('search').'%')
                              ->orWhere('description' , 'like', '%'.request('search').'%');
                      })
                      ->orWhereHas('user',function($q){
                            $q->where('name', 'like', '%'.request('search').'%')
                                ->orWhere('email' , 'like', '%'.request('search').'%')
                                ->orWhere('phone' , 'like', '%'.request('search').'%')
                                ->orWhere('birthdate' , 'like', '%'.request('search').'%')
                                ->orWhere('gender' , 'like', '%'.request('search').'%');
                  });
            });
        }
        $orders = $orders->simplepaginate();
        return $this->sendResponse(resource_collection(OrderTableResource::collection($orders)));
    }
    public function show(Order $order){
        $order->load('user','orderDetails.product');
        return $this->sendResponse(new OrderResource($order));
    }
    public function changeStatus(Order $order, $status){
        if(checkOrderStatus($status) == false){
            return $this->sendResponse(['error' =>   __('messages.Order status is invalid!')],'fail',400);
        }
        $order->update(['status' => $status]);
        return $this->sendResponse([]);
    }
}
