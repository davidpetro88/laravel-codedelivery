@extends('app')

@section('content')

    <div class="container">
        <h3>Editando Cupom {{$cupom->name}}</h3>

        {!! Form::model($cupom,['route'=>['admin.cupoms.update',$cupom->id]]) !!}

        @include('admin.cupoms._form')

        {!! Form::close() !!}
    </div>

@endsection