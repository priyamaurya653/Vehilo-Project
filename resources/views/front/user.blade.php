@extends('front.main')

{{-- Ye page sirf normal user ke liye hai --}}
@section('role', 'user')
@section('title', 'My Dashboard')
@section('page_title', 'Dashboard')

@section('content')

    <div class="welcome">
        <div>
            <h2>Hi, <span class="js-user-name">there</span></h2>
            <p>Apni rides, payments aur profile ek jagah.</p>
        </div>
        <a href="{{ url('/user/bookings') }}" class="btn btn-accent">Book a ride</a>
    </div>

    {{-- Stats (sample values, API se replace karo) --}}
    <div class="stats">
        <div class="stat-card">
            <div class="stat-label">Total rides</div>
            <div class="stat-value">18</div>
            <div class="stat-note">Since joining</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Upcoming</div>
            <div class="stat-value">1</div>
            <div class="stat-note">Sat, 27 Sep</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Wallet balance</div>
            <div class="stat-value">₹350</div>
            <div class="stat-note">Use on next ride</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">CO₂ saved</div>
            <div class="stat-value">42 kg</div>
            <div class="stat-note up">By riding electric</div>
        </div>
    </div>

    <div class="grid-2">
        <div class="panel">
            <div class="panel-head">
                <h3>Recent rides</h3>
                <a href="{{ url('/user/bookings') }}">View all</a>
            </div>
            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr><th>Date</th><th>Vehicle</th><th>Duration</th><th>Amount</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        <tr><td>27 Sep</td><td>Tata Nexon EV</td><td>1 day</td><td>₹2,300</td><td><span class="badge warn">Upcoming</span></td></tr>
                        <tr><td>20 Sep</td><td>Ather 450X</td><td>4 hrs</td><td>₹640</td><td><span class="badge good">Completed</span></td></tr>
                        <tr><td>14 Sep</td><td>Ola S1 Pro</td><td>3 hrs</td><td>₹480</td><td><span class="badge good">Completed</span></td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="panel">
            <div class="panel-head"><h3>Account</h3></div>
            <div class="quick-list">
                <a href="{{ url('/user/payments') }}" class="quick-link">Payments <small>3 this month</small></a>
                <a href="{{ url('/user/profile') }}" class="quick-link">Edit profile <small></small></a>
                <a href="{{ url('/user/help') }}" class="quick-link">Get help <small>24/7</small></a>
            </div>
        </div>
    </div>

@endsection