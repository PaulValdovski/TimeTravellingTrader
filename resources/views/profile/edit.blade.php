<head>
<title>Edit Profile</title>
</head>

<x-app-layout>
<div style="background-image: url('https://img.freepik.com/free-vector/graph-world-map-stock-market-forex-trading-concept-background_56104-1006.jpg?w=826&t=st=1699038434~exp=1699039034~hmac=fc76565d0803f4ec66c6f4e72107d7c02573fc94ae79c62a764851fc497fd444'); background-size: cover;">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
