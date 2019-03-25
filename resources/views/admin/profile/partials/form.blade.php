@if(!empty($user))
    {{ Form::model($user, ['route' => ['admin.users.update', $user], 'method' => 'put', 'files'=> true]) }}
@else
    {!! Form::open(['route' => 'admin.users.store']) !!}
@endif

@include('profile.partials.fields')

{{ Form::close() }}