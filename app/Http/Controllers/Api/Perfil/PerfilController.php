<?php

/**
 * Created by PhpStorm.
 * User: david
 * Date: 5/2/16
 * Time: 9:06 PM
 */
namespace CodeDelivery\Http\Controllers\Api\Perfil;

use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Repositories\UserRepository;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;


class PerfilController extends Controller
{
    /**
     * @var UserRepository
     */
    private $repository;
    /**
     * PerfilController constructor.
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }
    public function show()
    {
        return $this->repository->find(Authorizer::getResourceOwnerId());
    }
}