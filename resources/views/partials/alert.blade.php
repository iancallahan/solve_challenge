@if ( Session::has('alert_message'))
    <div class="alert alert-{{ Session::get('alert_class') }} alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">×</button>
        {{ ucwords(Session::get('alert_class')) }}: {{ Session::get('alert_message') }}
    </div>
@endif
