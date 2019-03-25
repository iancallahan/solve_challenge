@if(Auth::user()->hasRole('admin'))
<table class="table table-striped table-hover">
    <thead>
      <tr>
        <th class="col-md-1">Created</th>
        <th class="col-md-2">Name<a id="sortAsc" href="{{route(Route::currentRouteName(), ['sort' => 'asc'])}}"><i class="fa fa-sort-asc" aria-hidden="true"></i></a><a id="sortDesc" href="{{route(Route::currentRouteName(), ['sort' => 'desc'])}}"><i class="fa fa-sort-desc" aria-hidden="true"></i></a></th>
        <th class="col-md-1"><a href="{{{ route('admin.users.create') }}}" class="btn btn-primary"><span class="glyphicon"></span>Create User</a></th>
      </tr>
    </thead>

    <tbody>
      @foreach ($users as $index => $user)
        <tr class="{{$index%2 == 0 ? "even" : "odd"}}">
          <td>{{$user->created_at->format('m-d-y')}}</td>
          <td>{{$user->name}}</td>
          <td>
            <a href="{{{ URL::route('admin.users.edit', $user->id) }}}" class="btn btn-default btn-xs">Edit</a>
            <a href="{{{ URL::route('admin.users.destroy', $user->id) }}}" data-resource="event" data-resource_id="{{$user->id}}" class="btn btn-danger btn-xs btn-delete">Delete</a>
          </td>
        </tr>
      @endforeach
    </tbody>
</table>
@endif
