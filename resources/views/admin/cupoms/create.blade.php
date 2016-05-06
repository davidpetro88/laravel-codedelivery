@extends('app')

@section('content')

    <div class="container">
        <h3>Novo Cupom</h3>

        {!! Form::open(['route'=>'admin.cupoms.store']) !!}

        @include('admin.cupoms._form')

        {!! Form::close() !!}
    </div>

@endsection