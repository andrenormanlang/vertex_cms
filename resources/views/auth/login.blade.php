@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-3xl font-semibold text-center mb-6">Login</h2>

        @if ($errors->any())
            <div class="mb-4">
                <ul class="list-disc list-inside text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full px-4 py-2 border border-gray-300 rounded-md">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" type="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded-md">
            </div>

            <div class="flex items-center justify-between mb-6">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300">
                    <span class="ml-2 text-sm text-gray-700">Remember me</span>
                </label>

                <a href="{{ route('password.request') }}" class="text-sm text-blue-500 hover:text-blue-700">
                    Forgot your password?
                </a>
            </div>

            <button type="submit" class="w-full py-3 bg-blue-500 text-white rounded-md hover:bg-blue-700">
                Login
            </button>
        </form>
    </div>
</div>
@endsection
