<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 5/2/16
 * Time: 9:04 PM
 */

namespace CodeDelivery\Http\Controllers\Api\Client;


use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Repositories\ProductRepository;

class ClientProductController extends Controller
{
    /**
     * @var ProductRepository
     */
    private $repository;
    /**
     * ClientProductController constructor.
     * @param ProductRepository $repository
     */
    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }
    public function index()
    {
        return $this->repository->skipPresenter(false)->all();
    }
}