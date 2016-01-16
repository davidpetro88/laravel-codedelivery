<?php

namespace CodeDelivery\Http\Controllers\Api\Client;


use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\ProductRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Services\OrderService;
use CodeDelivery\Http\Requests;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ClientCheckoutController extends Controller
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
     * @var ProductRepository
     */
    private $productRepository;

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
                                ProductRepository $productRepository,
                                OrderService $orderService
    )
    {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->service = $orderService;
    }

    public function index()
    {
        $id = Authorizer::getResourceOwnerId();
        $clientId = $this->userRepository->find($id)->client->id;
        return $this->orderRepository->skipPresenter(false)
                                     ->with($this->with)
                                     ->scopeQuery(function($query) use($clientId) {
            return $query->where('client_id', '=', $clientId);
        })->paginate();
    }

    public function create()
    {
        $products = $this->productRepository->lists();
        return view('customer.order.create', compact('products'));
    }

    public function store(Requests\CheckoutRequest $request)
    {
        $id = Authorizer::getResourceOwnerId();
        $data = $request->all();
        $data['client_id'] = $this->userRepository->find($id)->client->id;
        return $this->orderRepository->skipPresenter(false)
                                     ->with($this->with)
                                     ->find($this->service->create($data)->id);
    }

    public function show($id)
    {
        return $this->orderRepository->skipPresenter(false)
                                     ->with($this->with)->find($id);
    }

}