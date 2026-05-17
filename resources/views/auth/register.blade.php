<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gu-dark">Create account</h2>
        <p class="text-sm text-gray-500 mt-1">Join the Griffith WIL Platform</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div class="form-group">
            <label for="name" class="form-label">Full name</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}"
                class="form-input" required autofocus autocomplete="name"
                placeholder="Your full name" />
            <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
        </div>

        <div class="form-group">
            <label for="email" class="form-label">Email address</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}"
                class="form-input" required autocomplete="username"
                placeholder="you@griffith.edu.au" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div class="form-group">
            <label for="usertype" class="form-label">I am a</label>
            <select id="usertype" name="usertype" class="form-select" required>
                <option value="">Select your role</option>
                <option value="student" {{ old('usertype') === 'student' ? 'selected' : '' }}>Student</option>
                <option value="industry_partner" {{ old('usertype') === 'industry_partner' ? 'selected' : '' }}>Industry Partner</option>
            </select>
            <p class="text-xs text-gray-400 mt-1">Teachers are provisioned by the administrator.</p>
            <x-input-error :messages="$errors->get('usertype')" class="mt-1.5" />
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input id="password" name="password" type="password"
                class="form-input" required autocomplete="new-password"
                placeholder="Min. 8 characters" />
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <div class="form-group">
            <label for="password_confirmation" class="form-label">Confirm password</label>
            <input id="password_confirmation" name="password_confirmation" type="password"
                class="form-input" required autocomplete="new-password"
                placeholder="Repeat your password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
        </div>

        <x-primary-button class="w-full justify-center">Create account</x-primary-button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-500">
        Already have an account?
        <a href="{{ route('login') }}" class="font-semibold text-gu-navy hover:underline">Sign in</a>
    </p>
</x-guest-layout>
