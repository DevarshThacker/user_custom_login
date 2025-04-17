@extends('layout')

@section('content')
<div class="container">
    <h1 class="text-center">Dashboard</h1>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Country</th>
                <th>State</th>
                <th>City</th>
                <th>Image</th>
                <th>Registered At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->country }}</td>
                <td>{{ $user->state }}</td>
                <td>{{ $user->city }}</td>
                <td><img src="{{ asset('images2/' . $user->image) }}" width="60" height="60"></td>
                <td>{{ $user->created_at->format('Y-m-d') }}</td>
                <td>
                    <a href="{{ route('edit', $user->id) }}"
                        class="btn btn-primary btn-sm">Edit</a>

                    {{-- <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
                        Edit
                    </button> --}}
                    <form action="{{ route('destroy', $user->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('{{$user->id}}:Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
