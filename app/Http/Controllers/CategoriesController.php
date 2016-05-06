<?php

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Repositories\CategoryRepository;
use CodeDelivery\Http\Requests\AdminCategoryRequest;
use CodeDelivery\Services\CategoryService;

class CategoriesController extends Controller
{
    /**
     * @var CategoryRepository
     */
    private $service;
    public function __construct(CategoryService $service) {
        $this->service = $service;
    }
    public function index(){
        $categories = $this->service->paginate();
        return view('admin.categories.index', compact('categories'));
    }
    /**
     * Metodo GET para mostrar formulario na tela
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){
        return view('admin.categories.create');
    }
    public function store(AdminCategoryRequest $request){
        $data = $request->all();
        $this->service->create($data);
        return redirect()->route('admin.categories.index');
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
