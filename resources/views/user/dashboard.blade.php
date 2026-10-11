@extends('frontlayout.main')

@section('content')

<div class="min-h-screen bg-[#F0F7F3] p-6">

    <div class="mx-auto max-w-7xl">

        <div class="mb-8 flex items-center justify-between">

            <div>

                <p class="text-sm text-slate-500">
                    VEHILO User
                </p>

                <h1
                    id="userName"
                    class="text-3xl font-extrabold text-[#051A13]"
                >
                    User Dashboard
                </h1>

            </div>


            <button
                onclick="logout()"
                class="rounded-xl bg-[#051A13] px-5 py-3 text-sm font-bold text-white"
            >
                Logout
            </button>

        </div>


        <div class="rounded-2xl bg-white p-7 shadow-sm">

            <h2 class="text-xl font-extrabold">
                Welcome to VEHILO
            </h2>

            <p class="mt-2 text-sm text-slate-500">
                Your user dashboard is ready.
            </p>

        </div>

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
    user.role !== 'user'
) {

    window.location.href =
        '{{ url("/login") }}';

}


document.getElementById(
    'userName'
).innerText =
    'Welcome, ' + user.name;


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

</script>

@endsection