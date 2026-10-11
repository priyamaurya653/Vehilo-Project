@extends('front.main')

{{-- Ye page sirf superadmin ke liye hai (dusra role aaya to apne dashboard par redirect) --}}
@section('role', 'superadmin')
@section('title', 'Super Admin Dashboard')
@section('page_title', 'Dashboard')

@section('content')

    <div class="welcome">
        <div>
            <h2>Welcome back, <span class="js-user-name">Super Admin</span></h2>
            <p>Partners, users aur bookings ka poora overview yahan hai.</p>
        </div>
        <a href="{{ url('/superadmin/partners/requests') }}" class="btn btn-accent">Review partner requests</a>
    </div>

    {{-- Stats (abhi sample values, API se replace karo) --}}
    <div class="stats">
        <div class="stat-card">
            <div class="stat-label">Total partners</div>
            <div class="stat-value" id="statPartners">128</div>
            <div class="stat-note up">+6 this month</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Total users</div>
            <div class="stat-value" id="statUsers">4,512</div>
            <div class="stat-note up">+312 this month</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Bookings today</div>
            <div class="stat-value" id="statBookings">86</div>
            <div class="stat-note">12 in progress</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Revenue this month</div>
            <div class="stat-value" id="statRevenue">₹3.4L</div>
            <div class="stat-note down">-4% vs last month</div>
        </div>
    </div>

    <div class="grid-2">
        <div class="panel">
            <div class="panel-head">
                <h3>Pending partner requests</h3>
                <a href="{{ url('/superadmin/partners/requests') }}">View all</a>
            </div>
            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr><th>Partner</th><th>City</th><th>Vehicles</th><th>Applied</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        <tr><td>GreenRide Motors</td><td>Faridabad</td><td>24</td><td>22 Sep</td><td><span class="badge warn">Pending</span></td></tr>
                        <tr><td>Volt Fleet Co.</td><td>Gurugram</td><td>12</td><td>21 Sep</td><td><span class="badge warn">Pending</span></td></tr>
                        <tr><td>CityEV Rentals</td><td>Noida</td><td>40</td><td>19 Sep</td><td><span class="badge good">Verified</span></td></tr>
                        <tr><td>Swift Wheels</td><td>Delhi</td><td>8</td><td>18 Sep</td><td><span class="badge bad">Documents missing</span></td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="panel">
            <div class="panel-head"><h3>Quick actions</h3></div>
            <div class="quick-list">
                <a href="{{ url('/superadmin/users') }}" class="quick-link">Manage users <small>4,512</small></a>
                <a href="{{ url('/superadmin/bookings') }}" class="quick-link">All bookings <small>Today 86</small></a>
                <a href="{{ url('/superadmin/reports/export') }}" class="quick-link">Export data <small>CSV</small></a>
                <a href="{{ url('/superadmin/settings') }}" class="quick-link">Platform settings <small></small></a>
            </div>
        </div>
    </div>

@endsection