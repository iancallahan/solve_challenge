<div class="form-group @if($errors->has($name)) has-error @endif">
  {!! Form::label($name, $niceName) !!}
  {!! Form::file($name, $attributes) !!}
  @if ($errors->has($name))
      <span class="help-block">
          <strong>{{ $errors->first($name) }}</strong>
      </span>
  @endif
</div>
