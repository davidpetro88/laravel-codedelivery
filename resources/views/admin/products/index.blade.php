@extends('app')

@section('content')

    <div class="container">
        <h3>Produtos</h3>

        <a href="{{route('admin.products.create')}}" class="btn btn-default">Novo Produto</a>


        <table class="table">
            <thead>
            <th>ID</th>
            <th>Nome</th>
            <th>Categoria</th>
            <th>Acao</th>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{$product->id}}</td>
                    <td>{{$product->name}}</td>
                    <td>{{$product->category->name}}</td>
                    <td>
                        <a href="{{route('admin.products.edit',['id'=>$product->id])}}" class="btn btn-default btn-sm">Editar</a>
                        <a href="{{route('admin.products.destroy',['id'=>$product->id])}}" class="btn btn-danger btn-sm">Remover</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $products->render() !!}

    </div>

@endsection