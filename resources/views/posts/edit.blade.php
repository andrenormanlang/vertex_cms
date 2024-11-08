@extends('layouts.app')

<form action="{{ route('profile.update') }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Update Profile</button>
</form>
