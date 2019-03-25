@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Manage Users</div>
                <div class="card-body">
                    @include('partials/alert')
                    @include('users.partials.table')
                    <div class="pagination">{{ $users->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection