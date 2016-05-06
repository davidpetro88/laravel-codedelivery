<div class="form-group">
    {!!Form::label('Codigo','Código') !!}
    {!!Form::text('code',null,['class'=>'form-control','id'=>'code']) !!}
</div>
<div class="form-group">
    {!!Form::label('Valor','Valor') !!}
    {!!Form::text('value',null,['class'=>'form-control','id'=>'value']) !!}
</div>

<div class="form-group">
    {!! Form::submit('Salvar', ['class'=>'btn btn-primary']) !!}
</div>