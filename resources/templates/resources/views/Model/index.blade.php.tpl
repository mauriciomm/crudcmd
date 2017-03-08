
@extends('layouts.app')

@section('content')
    <h4>[Model]</h4>
    {{ link_to_route('[tablename].create', 'Criar novo', null, ['class' => 'btn btn-default']) }}
    <hr/>
    {!! $table !!}
@endsection
