<div class="form-group @if($errors->has($name)) has-error @endif">
  {!! Form::label($name, $niceName) !!}
  {{ Form::password('password', array('placeholder' => 'New Password', 'class' => 'form-control profile-password')) }}
  {{ Form::password('password_confirmation', array('placeholder' => 'Confirm New Password', 'class' => 'form-control profile-password')) }}
  @if ($errors->has($name))
      <span class="help-block">
          <strong>{{ $errors->first($name) }}</strong>
      </span>
  @endif
</div>
