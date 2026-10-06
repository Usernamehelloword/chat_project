<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
@include('partials.loader')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Created At</th>
            <th>Updated At</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>{{$user->number_id}}</td>
                <td>{{ $user->created_at }}</td>
                <td>{{ $user->updated_at }}</td>
                <td>
                    <a href="{{ route('users.edit', $user->id) }}">Edit</a>
                   <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                             @csrf
                         <button type="submit" onclick="return confirm('Delete this user?')">
                             Delete
                              </button>
                        </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">No users found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
<a href="{{ route('logins') }}">Logout</a>
</body>
</html>