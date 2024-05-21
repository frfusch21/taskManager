<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://unpkg.com/tailwindcss@2.0.1/dist/tailwind.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-6">Login</h2>
            @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
                    {{ session('error') }}
                </div>
            @endif
            <form id="loginForm" onsubmit="event.preventDefault(); login();">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email</label>
                    <input type="email" id="email" name="email" class="w-full p-2 border border-gray-300 rounded mt-1" required>
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-gray-700">Password</label>
                    <input type="password" id="password" name="password" class="w-full p-2 border border-gray-300 rounded mt-1" required>
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Login</button>
            </form>
            <p class="mt-4 text-center">
                Don't have an account? <a href="{{ route('register') }}" class="text-blue-500">Register</a>
            </p>
        </div>
    </div>
</body>
<script>
    function login() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const email = document.querySelector('#email').value;
        const password = document.querySelector('#password').value;

        fetch('/api/login-form', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ email, password })
        }).then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        }).then(data => {
            if (data.access_token) {
                localStorage.setItem('token', data.access_token);
                alert('Login successful');
                window.location.href = '/tasks';
            } else {
                alert('Login failed');
            }
        }).catch(error => {
            console.error('Login error:', error);
            alert('Login error');
        });
    }
</script>
</html>
