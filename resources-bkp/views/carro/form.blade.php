{!! Form::model($model, ['route' => $route, 'method' => $method]) !!}
    @foreach($model['attributes'] as $attribute)
        <p>
            {{ Form::label($attribute) }}
            {{ Form::text($attribute) }}
        </p>
    @endforeach
    <p>
        {{ Form::submit('salvar') }}
    </p>
{!! Form::close() !!}
