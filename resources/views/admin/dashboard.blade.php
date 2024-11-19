@extends('layouts.admin')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Admin Dashboard</h1>
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Welcome, {{ Auth::user()->email }}</h2>
        <p class="mb-4">This is your admin dashboard where you can manage users, view reports, and perform administrative tasks.</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-santa-green text-white p-4 rounded-lg shadow">
                <h3 class="font-bold">Manage Users</h3>
                <p>View and manage all registered users.</p>
                <a href="{{ route('admin.users') }}" class="text-santa-gold hover:underline"><i class="fas fa-arrow-right mr-2"></i>Go to Users</a>
            </div>
            <div class="bg-santa-maroon text-white p-4 rounded-lg shadow">
                <h3 class="font-bold">Reports</h3>
                <p>View various reports related to user activities.</p>
                <a href="{{ route('admin.reports') }}" class="text-santa-gold hover:underline"><i class="fas fa-arrow-right mr-2"></i>View Reports</a>
            </div>
            <!-- Add more sections as needed -->
        </div>
    </div>
</div>
@endsection