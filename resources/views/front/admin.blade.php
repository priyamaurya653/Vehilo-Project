@extends('front.main')

{{-- Ye page sirf admin (partner) ke liye hai --}}
@section('role', 'admin')
@section('title', 'Partner Dashboard')
@section('page_title', 'Dashboard')

@section('content')

    <div class="welcome">
        <div>
            <h2>Welcome back, <span class="js-user-name">Partner</span></h2>
            <p>Apni fleet, bookings aur earnings yahan se manage karo.</p>
        </div>
        <a href="{{ url('/admin/vehicles/create') }}" class="btn btn-accent">Add vehicle</a>
    </div>

    {{-- Stats (sample values, API se replace karo) --}}
    <div class="stats">
        <div class="stat-card">
            <div class="stat-label">My vehicles</div>
            <div class="stat-value">24</div>
            <div class="stat-note">18 available now</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Active bookings</div>
            <div class="stat-value">6</div>
            <div class="stat-note">2 ending today</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Earnings this month</div>
            <div class="stat-value">₹82,400</div>
            <div class="stat-note up">+11% vs last month</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Rating</div>
            <div class="stat-value">4.7</div>
            <div class="stat-note">From 212 rides</div>
        </div>
    </div>

    <div class="grid-2">
        <div class="panel">
            <div class="panel-head">
                <h3>Recent bookings</h3>
                <a href="{{ url('/admin/bookings') }}">View all</a>
            </div>
            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr><th>Booking</th><th>Customer</th><th>Vehicle</th><th>Amount</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        <tr><td>#BK-1042</td><td>Rahul S.</td><td>Ather 450X</td><td>₹640</td><td><span class="badge good">Completed</span></td></tr>
                        <tr><td>#BK-1041</td><td>Neha K.</td><td>Tata Nexon EV</td><td>₹2,300</td><td><span class="badge warn">Ongoing</span></td></tr>
                        <tr><td>#BK-1039</td><td>Amit V.</td><td>Ola S1 Pro</td><td>₹480</td><td><span class="badge good">Completed</span></td></tr>
                        <tr><td>#BK-1037</td><td>Priya M.</td><td>MG ZS EV</td><td>₹1,900</td><td><span class="badge bad">Cancelled</span></td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="panel">
            <div class="panel-head"><h3>Quick actions</h3></div>
            <div class="quick-list">
                <a href="{{ url('/admin/vehicles') }}" class="quick-link">Manage vehicles <small>24</small></a>
                <a href="{{ url('/admin/earnings') }}" class="quick-link">Payout history <small></small></a>
                <a href="{{ url('/admin/profile') }}" class="quick-link">Business profile <small></small></a>
            </div>
        </div>
    </div>

@endsection