<div class="form-group @if($errors->has($name)) has-error @endif">
  {!! Form::label($name, $niceName) !!}
  {!! Form::text($name, empty($resource) ? '' : $resource->getOriginal($name), array_merge(['class' => 'form-control'], array_merge($required, $readonly, $attributes))) !!}
  @if ($errors->has($name))
      <span class="help-block">
          <strong>{{ $errors->first($name) }}</strong>
      </span>
  @endif
</div>
