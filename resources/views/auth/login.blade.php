<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Login | MYSpareParts</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('frontend/assets/images/favicon.ico') }}">

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('{{ asset('frontend/assets/images/auth-bg.jpg') }}');">
    <div class="bg-white bg-opacity-90 shadow-lg rounded-lg w-full max-w-md p-6">
        <div class="text-center mb-6">
            <a href="{{ url('/') }}" class="inline-block">
                <img src="{{ asset('frontend/assets/images/auth-login-light.png') }}" alt="Logo" class="h-10 mx-auto">
            </a>
            <h4 class="text-2xl font-semibold text-gray-800 mt-4">Sign In</h4>
        </div>

        <form method="POST" action="{{ route('login.submit') }}" class="space-y-4">
            @csrf

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-gray-700 font-medium">Email</label>
                <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('email') border-red-500 @enderror" placeholder="Email address" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-gray-700 font-medium">Password</label>
                <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('password') border-red-500 @enderror" placeholder="Password" required>
                @error('password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Log In
                </button>
            </div>

            <!-- Display Error and Success Messages -->
            @if(session('error'))
                <div class="bg-red-100 text-red-600 p-3 mt-4 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif
            @if(session('success'))
                <div class="bg-green-100 text-green-600 p-3 mt-4 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
        </form>
    </div>

    <!-- JavaScript (optional, remove if not needed) -->
    <script src="{{ asset('frontend/assets/js/app.js') }}"></script>
</body>
</html>
