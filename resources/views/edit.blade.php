<!-- filepath: c:\xampp8.2\htdocs\user_custom_login\resources\views\edit.blade.php -->
@extends('layout')

@section('content')
<div class="container">
    <h1>Edit User</h1>
    <form action="{{ route('update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
            @if ($errors->has('email'))

            <span class="text-danger">{{ $errors->first('email') }}</span>

        @endif
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password (Leave blank to keep current password)</label>
            <input type="password" name="password" id="password" class="form-control">
            @if ($errors->has('password'))

            <span class="text-danger">{{ $errors->first('password') }}</span>

        @endif
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
            @if ($errors->has('password'))

            <span class="text-danger">{{ $errors->first('password') }}</span>

        @endif
        </div>
        <div class="mb-3">
            <label for="image">Upload Image:</label>
            <input type="file" id="image" name="image" class="form-control" >
            <img src="{{ asset('images2/' . $user->image) }}" width="60" height="60"><br><br>

        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        {{-- <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancel</a> --}}
    </form>
</div>
@endsection
