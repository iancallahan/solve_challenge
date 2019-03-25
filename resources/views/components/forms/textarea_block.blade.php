<div class="form-group @if($errors->has($name)) has-error @endif">
  {!! Form::label($name, $niceName) !!}
  {!! Form::textarea($name, empty($resource) ? '' : $resource->getOriginal($name), array_merge(['class' => 'form-control'], $attributes)) !!}
  @if ($errors->has($name))
      <span class="help-block">
          <strong>{{ $errors->first($name) }}</strong>
      </span>
  @endif
</div>
