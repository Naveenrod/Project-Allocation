<nav x-data="{ open: false }" class="bg-gu-navy shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- Brand + Desktop Nav -->
            <div class="flex items-center">
                <!-- Logo / Brand -->
                <a href="{{ url('/') }}" class="flex items-center gap-2 mr-8">
                    <div class="w-8 h-8 rounded-md bg-gu-gold flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                        </svg>
                    </div>
                    <span class="text-white font-bold text-base tracking-tight hidden sm:block">
                        <span class="text-gu-gold">Griffith</span> WIL
                    </span>
                </a>

                <!-- Desktop Navigation Links -->
                <div class="hidden sm:flex sm:items-center sm:gap-1">
                    <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'nav-link-active' : 'nav-link' }}">
                        Home
                    </a>
                    <a href="{{ url('/projects/') }}" class="{{ request()->is('projects*') ? 'nav-link-active' : 'nav-link' }}">
                        Projects
                    </a>

                    @auth
                        @if (Auth::user()->usertype === 'teacher')
                            <a href="{{ url('/industry-partners/approval-menu') }}" class="{{ request()->is('industry-partners/approval-menu') ? 'nav-link-active' : 'nav-link' }}">
                                Approvals
                            </a>
                            <a href="{{ route('students.index') }}" class="{{ request()->is('students') ? 'nav-link-active' : 'nav-link' }}">
                                Students
                            </a>
                        @endif

                        @if (Auth::user()->usertype === 'industry_partner')
                            <a href="{{ url('/create-project') }}" class="{{ request()->is('create-project') ? 'nav-link-active' : 'nav-link' }}">
                                + Create Project
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Right side: User Dropdown -->
            <div class="hidden sm:flex sm:items-center">
                @auth
                    <x-dropdown align="right" width="52">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-white/80 hover:text-white hover:bg-white/10 transition-colors duration-150 focus:outline-none">
                                <!-- Avatar initials -->
                                <div class="w-8 h-8 rounded-full bg-gu-gold flex items-center justify-center text-white font-bold text-xs flex-shrink-0">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div class="text-left hidden lg:block">
                                    <div class="text-white text-sm font-medium leading-tight">{{ Auth::user()->name }}</div>
                                    <div class="text-white/50 text-xs leading-tight capitalize">
                                        {{ str_replace('_', ' ', Auth::user()->usertype) }}
                                    </div>
                                </div>
                                <svg class="w-4 h-4 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ Auth::user()->email }}</p>
                                <span class="mt-1.5 badge-navy inline-flex">
                                    {{ ucfirst(str_replace('_', ' ', Auth::user()->usertype)) }}
                                </span>
                            </div>

                            @if (Auth::user()->usertype === 'student' && Auth::user()->student)
                                <x-dropdown-link :href="route('students.show', Auth::user()->student->id)">
                                    My Profile
                                </x-dropdown-link>
                            @endif

                            <x-dropdown-link :href="route('profile.edit')">
                                Account Settings
                            </x-dropdown-link>

                            <div class="border-t border-gray-100 mt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                        Sign Out
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                @endauth
            </div>

            <!-- Mobile Hamburger -->
            <div class="flex items-center sm:hidden">
                <button @click="open = !open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-white/70 hover:text-white hover:bg-white/10 focus:outline-none transition duration-150">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden border-t border-white/10">
        <div class="px-4 py-3 space-y-1">
            <a href="{{ url('/') }}" class="block px-3 py-2 text-sm text-white/80 hover:text-white hover:bg-white/10 rounded-md">Home</a>
            <a href="{{ url('/projects/') }}" class="block px-3 py-2 text-sm text-white/80 hover:text-white hover:bg-white/10 rounded-md">Projects</a>

            @auth
                @if (Auth::user()->usertype === 'teacher')
                    <a href="{{ url('/industry-partners/approval-menu') }}" class="block px-3 py-2 text-sm text-white/80 hover:text-white hover:bg-white/10 rounded-md">Approvals</a>
                    <a href="{{ route('students.index') }}" class="block px-3 py-2 text-sm text-white/80 hover:text-white hover:bg-white/10 rounded-md">Students</a>
                @endif
                @if (Auth::user()->usertype === 'industry_partner')
                    <a href="{{ url('/create-project') }}" class="block px-3 py-2 text-sm text-white/80 hover:text-white hover:bg-white/10 rounded-md">+ Create Project</a>
                @endif
            @endauth
        </div>

        @auth
            <div class="border-t border-white/10 px-4 py-3">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-9 h-9 rounded-full bg-gu-gold flex items-center justify-center text-white font-bold text-sm">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-white/50">{{ Auth::user()->email }}</p>
                    </div>
                </div>

                @if (Auth::user()->usertype === 'student' && Auth::user()->student)
                    <a href="{{ route('students.show', Auth::user()->student->id) }}" class="block px-3 py-2 text-sm text-white/80 hover:text-white hover:bg-white/10 rounded-md">My Profile</a>
                @endif
                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 text-sm text-white/80 hover:text-white hover:bg-white/10 rounded-md">Account Settings</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-3 py-2 text-sm text-white/80 hover:text-white hover:bg-white/10 rounded-md">Sign Out</button>
                </form>
            </div>
        @endauth
    </div>
</nav>
