<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 12/19/15
 * Time: 12:03 AM
 */

namespace CodeDelivery\Http\Controllers;


use CodeDelivery\Http\Requests\AdminOrderRequest;
use CodeDelivery\Http\Requests\Request;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Services\OrderService;

class OrdersController extends Controller
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;
    /**
     * @var OrderService
     */
    private $orderService;
    public function __construct(OrderRepository $orderRepository,OrderService $orderService)
    {
        $this->orderRepository = $orderRepository;
        $this->orderService = $orderService;
    }
    public function index(){
        $orders = $this->orderRepository->paginate();
        return view('admin.orders.index',compact('orders'));
    }
    public function edit($id,UserRepository $userRepository){
        $listStatus = [
            0=>'Pendente',
            1=>'A Caminho',
            2=>'Entregue'
        ];
        $order = $this->orderRepository->find($id);
        $deliveryMan = $userRepository->getDeliverymen();
        return view('admin.orders.edit',compact('order','listStatus','deliveryMan'));
    }
    public function update(AdminOrderRequest $request,$id){
        $data = $request->all();
        $this->orderService->update($data,$id);
        return redirect()->route('admin.orders.index');
    }
}