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
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <p>Name: {{ $user->name }}</p>
    <p>Email: {{ $user->email }}</p>
    <p>Role: {{ $user->role }}</p>
    <p>Created At: {{ $user->created_at }}</p>
    <p>Updated At: {{ $user->updated_at }}</p>
    <p>password: {{ $user->password }}</p>
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        <label for="name">Name:</label>
        <input type="text" name="name" value="{{ $user->name }}" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" value="{{ $user->email }}" required>
        <br>
        <label for="password">Password (leave blank to keep current password):</label>
        <input type="password" name="password">
        <br>
        <label for="password_confirmation">Confirm Password:</label>
        <input type="password" name="password_confirmation">
        <br>
        <button type="submit">Update</button>

</body>
</html>