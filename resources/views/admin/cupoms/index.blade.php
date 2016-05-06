@extends('app')

@section('content')

    <div class="container">
        <h3>Cupons</h3>

        <a href="{{route('admin.cupoms.create')}}" class="btn btn-default">Novo Cupom</a>


        <table class="table">
            <thead>
            <th>ID</th>
            <th>Codigo</th>
            <th>Valor</th>
            </thead>
            <tbody>
            @foreach($cupons as $cupom)
                <tr>
                    <td>{{$cupom->id}}</td>
                    <td>{{$cupom->code}}</td>
                    <td>R$ {{$cupom->value}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $cupons->render() !!}

    </div>

@endsection