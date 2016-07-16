<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 5/5/16
 * Time: 10:51 PM
 */

namespace CodeDelivery\Services;

use CodeDelivery\Repositories\CategoryRepository;

class CategoryService extends AbstractService
{
    public function __construct(CategoryRepository $repository)
    {
        parent::__construct($repository);
    }
}
