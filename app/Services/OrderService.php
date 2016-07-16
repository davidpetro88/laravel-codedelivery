<?php
namespace CodeDelivery\Services;
use CodeDelivery\Models\Order;
use CodeDelivery\Repositories\CupomRepository;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\ProductRepository;
use Dmitrovskiy\IonicPush\PushProcessor;
use Illuminate\Support\Facades\DB;
class OrderService
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;
    /**
     * @var CupomRepository
     */
    private $cupomRepository;
    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var PushProcessor
     */
    private $pushProcessor;
    public function __construct(
        OrderRepository $orderRepository,
        CupomRepository $cupomRepository,
        ProductRepository $productRepository,
        PushProcessor $pushProcessor)
    {
        $this->orderRepository = $orderRepository;
        $this->cupomRepository = $cupomRepository;
        $this->productRepository = $productRepository;
        $this->pushProcessor = $pushProcessor;
    }
    public function create(array $data){
        DB::beginTransaction();
        try {
            $data['status'] = 0;
            //para evitar que o usuario envie por api esse id
            if (isset($data['cupom_id'])){
                unset($data['cupom_id']);
            }
            if (isset($data['cupom_code'])){
                $cupom = $this->cupomRepository->findByField('code',$data['cupom_code'])->first();
                $data['cupom_id'] = $cupom->id;
                $cupom->used = 1;
                $cupom->save();
                unset($data['cupom_code']);
            }
            $items = $data['items'];
            unset($data['items']);
            $order = $this->orderRepository->create($data);
            $total = 0;
            foreach($items as $item){
                $item['price'] = $this->productRepository->find($item['product_id'])->price;
                $order->items()->create($item);
                $total +=$item['price'] * $item['qtd'];
            }
            $order->total = $total;
            if (isset($cupom)){
                $order->total = $total - $cupom->value;
            }
            $order->save();
            DB::commit();
            return $order;
        }catch (\Exception $e){
            DB::rollback();
            throw $e;
        }
    }
    public function update($data,$id){
        $this->orderRepository->update($data,$id);
        if ($data['status']== 0 && $data['user_deliveryman_id'] !=''){
            $order = $this->orderRepository->find($id);
            $user = $order->client->user;
            $this->pushProcessor->notify([$user->device_token],[
                'alert'=>"Seu Pedido {$order->id} foi despachado para o entregador."
            ]);
        }
    }
    public function updateStatus($id,$idDeliveryman,$status){
        $order = $this->orderRepository->getByIdAndDeliveryman($id,$idDeliveryman);
        $order->status = $status;
        switch((int) $status){
            case 1 :
                if (!$order->hash){
                    $order->hash = md5((new \DateTime())->getTimestamp());
                }
                $user = $order->client->user;
                $order->save();
                $this->pushProcessor->notify([$user->device_token],[
                    'alert'=>"Seu Pedido {$order->id} saiu para entrega."
                ]);
                break;
            case 2 :
                $user = $order->client->user;
                $order->save();
                $this->pushProcessor->notify([$user->device_token],[
                    'alert'=>"Seu Pedido {$order->id} foi entregue"
                ]);
                break;
        }
        return $order;
    }
}