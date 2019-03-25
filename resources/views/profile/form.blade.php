@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Edit Profile</div>
                <div class="card-body">
                    @include('partials/alert')
                    <div class="profile-form">
                        <div class="profile-image">
                            @if(!empty($user))
                                @if(!empty($user->headshot))
                                    <img src="{{$user->headshot}}" alt="A profile picture for {{$user->name}}">
                                @endif
                                @if(Request::is('users/*'))
                                    {{ Form::model($user, ['route' => ['admin.headshot.update', $user->id], 'method' => 'post', 'files' => true]) }}
                                        {{ Form::fileBlock($user, 'headshot', 'Profile Photo', ['required' => 'required']) }}
                                        {{ Form::submit('Upload') }}
                                    {{ Form::close() }}
                                @else
                                    {{ Form::model($user, ['route' => ['headshot.update', $user], 'method' => 'post', 'files' => true]) }}
                                        {{ Form::fileBlock($user, 'headshot', 'Profile Photo', ['required' => 'required']) }}
                                        {{ Form::submit('Upload') }}
                                    {{ Form::close() }}
                                @endif
                            @endif
                        </div>
                        <div class="profile-fields">
                            @if(empty($user))
                                {!! Form::open(['route' => 'admin.users.store']) !!}
                            @else
                                @if(Request::is('users/*'))
                                    {{ Form::model($user, ['route' => ['admin.users.update', $user->id], 'method' => 'post']) }}
                                @else
                                    {{ Form::model($user, ['route' => ['profile.update', $user], 'method' => 'post']) }}
                                @endif
                            @endif
                            
                            @include('profile.partials.fields')
                            {{ Form::close() }}
                            @if(!empty($user))
                                <biography :max-words='300'></biography>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection