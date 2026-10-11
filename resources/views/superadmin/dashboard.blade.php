@extends('front.main')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@push('styles')
<style>
    .stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
        gap: 1px;
        background: var(--line);
        border: 1px solid var(--line);
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 28px;
    }
    .stat { background: var(--surface); padding: 22px 24px; }
    .stat-label { color: var(--muted); font-size: .8rem; }
    .stat-value { font-family: 'Fraunces', serif; font-size: 2.1rem; font-weight: 500; margin: 6px 0 8px; }
    .stat-note { font-size: .78rem; color: var(--muted); display: inline-flex; align-items: center; gap: 5px; }
    .stat-note.up { color: var(--good); }
    .stat-note.down { color: var(--bad); }
    .stat-note::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: currentColor; opacity: .5; }

    .grid { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; align-items: start; }
    .panel { background: var(--surface); border: 1px solid var(--line); border-radius: 10px; }
    .panel-head {
        padding: 18px 24px;
        border-bottom: 1px solid var(--line);
        font-family: 'Fraunces', serif;
        font-size: 1.05rem;
        font-weight: 500;
    }

    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; font-size: .88rem; }
    th, td { text-align: left; padding: 13px 24px; border-bottom: 1px solid var(--line); white-space: nowrap; }
    th { color: var(--muted); font-weight: 500; font-size: .76rem; }
    tr:last-child td { border-bottom: none; }
    tbody tr:hover { background: color-mix(in srgb, var(--paper) 55%, transparent); }

    .badge { padding: 3px 11px; border-radius: 4px; font-size: .74rem; font-weight: 500; }
    .badge.active  { background: var(--good-tint); color: var(--good); }
    .badge.pending { background: var(--warn-tint); color: var(--warn); }
    .badge.blocked { background: var(--bad-tint);  color: var(--bad); }

    .activity { list-style: none; padding: 6px 0; }
    .activity li {
        padding: 13px 24px;
        font-size: .87rem;
        position: relative;
        padding-left: 40px;
    }
    .activity li::before {
        content: '';
        position: absolute;
        left: 24px; top: 19px;
        width: 7px; height: 7px;
        border-radius: 50%;
        background: var(--accent);
    }
    .activity li::after {
        content: '';
        position: absolute;
        left: 27px; top: 27px; bottom: -2px;
        width: 1px;
        background: var(--line);
    }
    .activity li:last-child::after { display: none; }
    .activity small { display: block; color: var(--muted); margin-top: 2px; }

    @media (max-width: 900px) {
        .grid { grid-template-columns: 1fr; }
        .stats { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 520px) {
        .stats { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')

@php
    // Demo data — controller se real data bhejne par ye hata dena
    $stats = $stats ?? [
        ['label' => 'Total Users',   'value' => '1,284',   'note' => '+12% is mahine', 'trend' => 'up'],
        ['label' => 'Orders',        'value' => '356',     'note' => '+4% is mahine',  'trend' => 'up'],
        ['label' => 'Revenue',       'value' => '₹84,200', 'note' => '-2% is mahine',  'trend' => 'down'],
        ['label' => 'Pending Tasks', 'value' => '18',      'note' => '5 aaj due hain', 'trend' => ''],
    ];

    $recentUsers = $recentUsers ?? [
        ['name' => 'Rahul Sharma', 'email' => 'rahul@example.com', 'date' => '24 Sep 2026', 'status' => 'active'],
        ['name' => 'Priya Verma',  'email' => 'priya@example.com', 'date' => '23 Sep 2026', 'status' => 'pending'],
        ['name' => 'Amit Kumar',   'email' => 'amit@example.com',  'date' => '22 Sep 2026', 'status' => 'active'],
        ['name' => 'Neha Singh',   'email' => 'neha@example.com',  'date' => '20 Sep 2026', 'status' => 'blocked'],
    ];

    $activities = $activities ?? [
        ['text' => 'Naya user register hua',   'time' => '10 min pehle'],
        ['text' => 'Order #1042 complete hua', 'time' => '1 ghante pehle'],
        ['text' => 'Settings update hui',      'time' => 'Kal'],
        ['text' => 'Report generate hui',      'time' => 'Kal'],
    ];
@endphp

<section class="stats">
    @foreach ($stats as $stat)
        <div class="stat">
            <div class="stat-label">{{ $stat['label'] }}</div>
            <div class="stat-value">{{ $stat['value'] }}</div>
            <div class="stat-note {{ $stat['trend'] }}">{{ $stat['note'] }}</div>
        </div>
    @endforeach
</section>

<section class="grid">
    <div class="panel">
        <div class="panel-head">Recent users</div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr><th>Name</th><th>Email</th><th>Joined</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @foreach ($recentUsers as $user)
                        <tr>
                            <td>{{ $user['name'] }}</td>
                            <td>{{ $user['email'] }}</td>
                            <td>{{ $user['date'] }}</td>
                            <td><span class="badge {{ $user['status'] }}">{{ ucfirst($user['status']) }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="panel">
        <div class="panel-head">Recent activity</div>
        <ul class="activity">
            @foreach ($activities as $item)
                <li>{{ $item['text'] }}<small>{{ $item['time'] }}</small></li>
            @endforeach
        </ul>
    </div>
</section>

@endsection