<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gu-dark">Sign in</h2>
        <p class="text-sm text-gray-500 mt-1">Welcome back to the Griffith WIL Platform</p>
    </div>

    <!-- Quick login for dev/testing -->
    <div class="mb-6 rounded-lg border border-blue-200 bg-blue-50 p-4">
        <p class="text-xs font-semibold text-blue-700 uppercase tracking-wide mb-2">Test Accounts</p>
        <select id="quick-login" onchange="fillLogin(this)"
            class="block w-full rounded-md border border-blue-300 bg-white px-3 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
            <option value="">Select a user to auto-fill...</option>
            <optgroup label="Students">
                <option value="T@mail.com">Tom — Student (GPA 5.5)</option>
                <option value="alice@mail.com">Alice — Student (GPA 6.5)</option>
                <option value="bob@mail.com">Bob — Student (GPA 4.0)</option>
                <option value="carol@mail.com">Carol — Student (GPA 5.0)</option>
                <option value="david@mail.com">David — Student (GPA 3.5)</option>
                <option value="emma@mail.com">Emma — Student (GPA 6.0)</option>
            </optgroup>
            <optgroup label="Teacher">
                <option value="garry@gmail.com">Garry — Teacher</option>
            </optgroup>
            <optgroup label="Industry Partners (approved)">
                <option value="medicare@mail.com">Medi Care</option>
                <option value="mygov@mail.com">My Gov</option>
                <option value="TSD@mail.com">Tank Stream Design</option>
            </optgroup>
            <optgroup label="Industry Partners (pending approval)">
                <option value="lskd@mail.com">LSKD</option>
                <option value="air@mail.com">AirTasker</option>
                <option value="canva@mail.com">Canva</option>
            </optgroup>
        </select>
        <p class="text-xs text-blue-500 mt-1.5">All accounts use password <span class="font-mono font-semibold">12345678</span></p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div class="form-group">
            <label for="email" class="form-label">Email address</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}"
                class="form-input" required autofocus autocomplete="username"
                placeholder="you@griffith.edu.au" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div class="form-group">
            <div class="flex items-center justify-between">
                <label for="password" class="form-label">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="text-xs text-gu-navy hover:underline">Forgot password?</a>
                @endif
            </div>
            <input id="password" name="password" type="password"
                class="form-input" required autocomplete="current-password"
                placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <div class="flex items-center gap-2">
            <input id="remember_me" name="remember" type="checkbox"
                class="rounded border-gray-300 text-gu-navy focus:ring-gu-navy" />
            <label for="remember_me" class="text-sm text-gray-600">Remember me</label>
        </div>

        <x-primary-button class="w-full justify-center">Sign in</x-primary-button>
    </form>

    @if (Route::has('register'))
        <p class="mt-6 text-center text-sm text-gray-500">
            Don't have an account?
            <a href="{{ route('register') }}" class="font-semibold text-gu-navy hover:underline">Create one</a>
        </p>
    @endif

    <script>
        function fillLogin(select) {
            if (select.value) {
                document.getElementById('email').value = select.value;
                document.getElementById('password').value = '12345678';
            }
        }
    </script>
</x-guest-layout>
