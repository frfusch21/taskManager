<!-- resources/views/auth/register.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://unpkg.com/tailwindcss@2.0.1/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div style="min-height:20vh;" class="flex items-center justify-center">
        <h1 class="font-bold text-5xl text-center mb-2 pt-4">Task Manager</h1>
    </div>
    <div class="flex items-center justify-center">
        <h3 class="font-bold text-center mb-2">by Farah Yulianti</h3>
    </div>
    <div style="min-height:90vh;" class="flex items-center justify-center">
        <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-6">Register</h2>
            @if (session('error'))
                <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
                    {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700">Name</label>
                    <input type="text" id="name" name="name" class="w-full p-2 border border-gray-300 rounded mt-1" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email</label>
                    <input type="email" id="email" name="email" class="w-full p-2 border border-gray-300 rounded mt-1" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700">Password (Minimum 8 Character)</label>
                    <input type="password" id="password" name="password" class="w-full p-2 border border-gray-300 rounded mt-1" required>
                </div>
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-gray-700">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="w-full p-2 border border-gray-300 rounded mt-1" required>
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Register</button>
            </form>
            <p class="mt-4 text-center">
                Already have an account? <a href="{{ route('login') }}" class="text-blue-500">Login</a>
            </p>
        </div>
    </div>
</body>
</html>
