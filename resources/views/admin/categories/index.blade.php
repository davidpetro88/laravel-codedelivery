@extends('app')

@section('content')

    <div class="container">
        <h3>Categorias</h3>

        <a href="{{route('admin.categories.create')}}" class="btn btn-default">Nova Categoria</a>


        <table class="table">
            <thead>
            <th>ID</th>
            <th>Nome</th>
            <th>Acao</th>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{$category->id}}</td>
                    <td>{{$category->name}}</td>
                    <td>
                        <a href="{{route('admin.categories.edit',['id'=>$category->id])}}" class="btn btn-default btn-sm">Editar</a>
                        <a href="{{route('admin.categories.destroy',['id'=>$category->id])}}" class="btn btn-danger btn-sm">Remover</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $categories->render() !!}

    </div>

@endsection