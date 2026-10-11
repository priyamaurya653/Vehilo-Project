@extends('frontlayout.main')

@section('content')

<div class="min-h-screen bg-[#F0F7F3] p-6">

    <div class="mx-auto max-w-7xl">

        <div class="mb-8 flex items-center justify-between">

            <div>

                <p class="text-sm text-slate-500">
                    Partner / Admin
                </p>

                <h1
                    id="welcome"
                    class="text-3xl font-extrabold text-[#051A13]"
                >
                    Admin Dashboard
                </h1>

            </div>


            <button
                onclick="logout()"
                class="rounded-xl bg-[#051A13] px-5 py-3 text-sm font-bold text-white"
            >
                Logout
            </button>

        </div>


        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">

            <div class="rounded-2xl bg-white p-6 shadow-sm">

                <p class="text-xs text-slate-500">
                    Total Vehicles
                </p>

                <h2
                    id="vehicles"
                    class="mt-2 text-3xl font-extrabold"
                >
                    0
                </h2>

            </div>


            <div class="rounded-2xl bg-white p-6 shadow-sm">

                <p class="text-xs text-slate-500">
                    Total Bookings
                </p>

                <h2
                    id="bookings"
                    class="mt-2 text-3xl font-extrabold"
                >
                    0
                </h2>

            </div>


            <div class="rounded-2xl bg-white p-6 shadow-sm">

                <p class="text-xs text-slate-500">
                    Earnings
                </p>

                <h2
                    id="earnings"
                    class="mt-2 text-3xl font-extrabold"
                >
                    ₹0
                </h2>

            </div>


            <div class="rounded-2xl bg-white p-6 shadow-sm">

                <p class="text-xs text-slate-500">
                    Active Vehicles
                </p>

                <h2
                    id="activeVehicles"
                    class="mt-2 text-3xl font-extrabold"
                >
                    0
                </h2>

            </div>

        </div>


        <div
            id="partnerDetails"
            class="mt-6 rounded-2xl bg-white p-6 shadow-sm"
        ></div>

    </div>

</div>


<script>

const token =
    localStorage.getItem('access_token');


const user =
    JSON.parse(
        localStorage.getItem('user') || 'null'
    );


if (
    !token ||
    !user ||
    user.role !== 'admin'
) {

    window.location.href =
        '{{ url("/login") }}';

}


async function loadDashboard()
{

    try {

        const response =
            await fetch(
                '{{ url("/api/v1/partner/dashboard") }}',
                {

                    headers: {

                        'Accept':
                            'application/json',

                        'Authorization':
                            'Bearer ' + token

                    }

                }
            );


        if (response.status === 401) {

            localStorage.clear();

            window.location.href =
                '{{ url("/login") }}';

            return;
        }


        const result =
            await response.json();


        if (!result.success) {

            alert(
                result.message ||
                'Unable to load dashboard.'
            );

            return;
        }


        const data =
            result.data;


        document.getElementById(
            'welcome'
        ).innerText =
            'Welcome, ' +
            data.user.name;


        document.getElementById(
            'vehicles'
        ).innerText =
            data.stats.total_vehicles;


        document.getElementById(
            'bookings'
        ).innerText =
            data.stats.total_bookings;


        document.getElementById(
            'earnings'
        ).innerText =
            '₹' +
            data.stats.total_earnings;


        document.getElementById(
            'activeVehicles'
        ).innerText =
            data.stats.active_vehicles;


        document.getElementById(
            'partnerDetails'
        ).innerHTML = `

            <h2 class="text-lg font-extrabold">
                Partner Details
            </h2>

            <div class="mt-4 grid gap-3 sm:grid-cols-2">

                <p>
                    <strong>Name:</strong>
                    ${data.user.name}
                </p>

                <p>
                    <strong>Email:</strong>
                    ${data.user.email}
                </p>

                <p>
                    <strong>Mobile:</strong>
                    ${data.user.mobile || '-'}
                </p>

                <p>
                    <strong>Role:</strong>
                    ${data.user.role}
                </p>

            </div>
        `;


    } catch(error) {

        console.error(error);

    }

}


async function logout()
{

    await fetch(
        '{{ url("/api/v1/logout") }}',
        {

            method: 'POST',

            headers: {

                'Accept':
                    'application/json',

                'Authorization':
                    'Bearer ' + token

            }

        }
    );


    localStorage.clear();

    window.location.href =
        '{{ url("/login") }}';
}


loadDashboard();

</script>

@endsection