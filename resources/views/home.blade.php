@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Home</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You have successfully logged in to this demo application. If you're a regular user, you can edit your <a href="{{route('profile.edit')}}">profile</a>. If you're an admin, you can also <a href="{{route('admin.users.index')}}">create, edit and delete users.</a> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
