<?php

namespace CodeDelivery\Http\Controllers\Api\Deliveryman;


use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Services\OrderService;
use Illuminate\Http\Request;
use CodeDelivery\Http\Requests;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;


class DeliverymanCheckoutController extends Controller
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var OrderService
     */
    private $service;

    /**
     * @var array
     */
    private $with = ['client', 'cupom', 'items'];

    public function __construct(OrderRepository $orderRepository,
                                UserRepository $userRepository,
                                OrderService $orderService)
    {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->service = $orderService;
    }

    public function index()
    {
        $id = Authorizer::getResourceOwnerId();
        return $this->orderRepository->skipPresenter(false)->with($this->with)->scopeQuery(function($query) use($id) {
            return $query->where('user_deliveryman_id', '=', $id);
        })->paginate();
    }

    public function show($id)
    {
        return $this->orderRepository->skipPresenter(false)->getByIdAndDeliveryman($id,Authorizer::getResourceOwnerId());
    }

    public function updateStatus(Request $request, $id)
    {
        $order = $this->service->updateStatus($id, Authorizer::getResourceOwnerId(), $request->get('status') );
        if($order) return $this->orderRepository->find($order->id);
        abort(400,"Order not found!");
    }

}