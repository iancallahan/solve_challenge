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
@section('scripts')
<script>
$( document ).ready(function() {
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    $( ".btn-delete" ).click(function(e) {
        var resource = $(this).data('resource');
        var resource_id = $(this).data('resource_id');
        
        e.preventDefault();
        if(window.confirm("Are you sure you want to delete this user?")){
                $.ajax({
                    url: '/' + resource + 's/' + resource_id,	
                    type: 'DELETE',
                    success: function(result) {
                    console.log(resource + " deleted? " + result);
                    }
                });
            }
        });

    $(document).ajaxStop(function(){
        window.location.reload();
    });
});
</script>
@endsection
