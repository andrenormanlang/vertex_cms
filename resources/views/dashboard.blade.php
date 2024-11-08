@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-8">Dashboard</h2>

        <div class="bg-white shadow-md rounded-lg p-6">
            <p class="text-gray-700">Welcome to your dashboard, {{ Auth::user()->name }}!</p>
            <!-- You can add more stats, links, or widgets here -->
        </div>
    </div>
@endsection
