<?php

namespace CodeDelivery\Repositories;

namespace CodeDelivery\Repositories;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeDelivery\Presenters\UserPresenter;
use CodeDelivery\Models\User;
/**
 * Class UserRepositoryEloquent
 * @package namespace CodeDelivery\Repositories;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    protected $skipPresenter = true;

    public function getDeliverymen()
    {
        return $this->model->where(['role' => 'deliveryman'])->lists('name', 'id');
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter()
    {
        return UserPresenter::class;
    }

    public function updateDeviceToken($id, $deviceToken)
    {
        $model = $this->model->find($id);
        $model->device_token = $deviceToken;
        $model->save();
        return $this->parserResult($model);
    }
}