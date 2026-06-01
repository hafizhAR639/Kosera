<!DOCTYPE html>

<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Login - KOSERA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style data-purpose="form-styling">
        /* Custom styling for input backgrounds to match the light grey appearance */
        .input-field {
            background-color: #dbe0e8 !important;
            border: none !important;
        }
        .input-field:focus {
            ring: 2px;
            ring-color: #006699;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4 bg-[#f0f2f8]">
    <!-- BEGIN: LoginContainer -->
    <main class="w-full max-w-md" data-purpose="login-card-container">
    <!-- BEGIN: LogoSection -->
    <div class="flex flex-col items-center mb-10" data-purpose="brand-identity">
        <!-- Using the local KOSERA logo -->
        <img alt="KOSERA Logo" class="max-w-[280px] h-auto" id="main-logo" src="{{ asset('img/logos/kosera-logo.png') }}"/>
    </div>
    <!-- END: LogoSection -->
    <!-- BEGIN: LoginForm -->
    <form action="#" class="space-y-6" data-purpose="auth-form" method="POST">
        @csrf
        <!-- Email Field -->
        <div class="flex flex-col space-y-2">
        <label class="text-gray-600 font-medium ml-1" for="email">Email</label>
        <input class="input-field w-full h-14 rounded-xl px-4 text-gray-700" id="email" name="email" required="" type="email"/>
            </div>
            <!-- Password Field (Kata Sandi) -->
            <div class="flex flex-col space-y-2">
        <label class="text-gray-600 font-medium ml-1" for="password">Kata Sandi</label>
        <input class="input-field w-full h-14 rounded-xl px-4 text-gray-700" id="password" name="password" required="" type="password"/>
            </div>
            <!-- Submit Button (Masuk) -->
            <div class="pt-4 flex justify-center">
        <button class="bg-[#006da0] hover:bg-[#005a84] text-gray font-bold py-3 px-16 rounded-lg text-lg transition-colors duration-200" data-purpose="submit-button" type="submit">
                Masuk
                </button>
        </div>
    </form>
    <!-- END: LoginForm -->
    </main>
    <!-- END: LoginContainer -->
</body>
</html>
