@extends('staff.dashboard.layout.base')
@section('content')

@can('create User')
<a href="#" class="btn btn-primary">Create User</a>
@endcan

@can('update User')
<a href="#" class="btn btn-secondary">Edit User</a>
@endcan

@can('delete User')
<form action="#" method="POST" style="display: inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">Delete User</button>
</form>
@endcan


@endsection
