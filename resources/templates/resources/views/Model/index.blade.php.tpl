
@extends('layouts.app')

@section('content')
    <h4>[Model]</h4>
    {{ link_to_route('[tablename].create', 'Criar novo', null, ['class' => 'btn btn-default']) }}
    <hr/>
    <h1>Casas</h1>
    <table class="table">
    @foreach($collection as $item)
        <tr>
        @foreach($item['attributes'] as $attribute => $value)
        <td>{{ $item->$attribute }}</td>
        @endforeach
        <td><a href="{{ route('casa.edit', $item->id) }}">Editar</a></td>
        <td><form action="{{ route('casa.destroy', $item->id) }}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="DELETE">
            <input type="submit" value="Excluir">
        </form></td>
        </tr>
    @endforeach
    </table>
@endsection

