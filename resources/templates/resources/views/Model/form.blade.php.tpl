{!! Form::model($model, ['route' => $route, 'method' => $method]) !!}
    <p>
        {{ Form::submit('salvar') }}
    </p>
{!! Form::close() !!}
