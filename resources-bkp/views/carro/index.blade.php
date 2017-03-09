
@extends('layouts.app')

@section('content')
    <h4>Carro</h4>
    {{ link_to_route('carro.create', 'Criar novo', null, ['class' => 'btn btn-default']) }}
    <hr/>
    {!! $table !!}
@endsection
