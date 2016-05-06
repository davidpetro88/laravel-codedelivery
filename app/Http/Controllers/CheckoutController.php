<?php

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Repositories\CategoryRepository;
use CodeDelivery\Http\Requests\AdminCategoryRequest;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\ProductRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Services\CategoryService;
use CodeDelivery\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CheckoutController extends Controller
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
    private $orderService;
    public function __construct(
        OrderRepository $orderRepository,
        UserRepository $userRepository,
        ProductRepository $productRepository,
        OrderService $orderService
    ) {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->orderService = $orderService;
    }
    public function index(){
        $clientId = $this->userRepository->find(Auth::user()->id)->client->id;
        $orders = $this->orderRepository->scopeQuery(function($query) use($clientId){
            return $query->where('client_id','=',$clientId);
        })->paginate();
        return view('customer.order.index', compact('orders'));
    }
    /**
     * Metodo GET para mostrar formulario na tela
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){
        $products = $this->productRepository->lists();
        return view('customer.order.create',compact('products'));
    }
    public function store(Request $request){
        $data = $request->all();
        $clientId = $this->userRepository->find(Auth::user()->id)->client->id;
        $data['client_id'] = $clientId;
        $this->orderService->create($data);
        return redirect()->route('customer.order.index');
    }
    public function edit($id){
        $category = $this->service->find($id);
        return view('admin.categories.edit',compact('category'));
    }
    public function update(AdminCategoryRequest $request,$id){
        $data = $request->all();
        $this->service->update($data,$id);
        return redirect()->route('admin.categories.index');
    }
    public function destroy($id){
        $this->service->delete($id);
        return redirect()->route('admin.categories.index');
    }
}