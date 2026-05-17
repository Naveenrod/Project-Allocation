<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
            <a href="{{ route('students.index') }}" class="hover:text-gu-navy transition-colors">Students</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gu-dark font-medium">{{ $student->name }}</span>
        </div>
        <div class="flex items-start justify-between">
            <div>
                <h1 class="section-title">{{ $student->name }}</h1>
                <p class="section-subtitle">Student Profile</p>
            </div>
            @if (auth()->user() && auth()->user()->id === $student->user_id)
                <a href="{{ route('students.edit', $student->id) }}" class="btn-secondary">Edit Profile</a>
            @endif
        </div>
    </x-slot>

    <div class="page-wrapper">
        <div class="grid gap-6 lg:grid-cols-3">

            <!-- Profile card -->
            <div class="lg:col-span-1 space-y-5">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="w-20 h-20 rounded-full bg-gu-navy flex items-center justify-center text-white font-bold text-3xl mx-auto mb-4">
                            {{ strtoupper(substr($student->name, 0, 1)) }}
                        </div>
                        <h2 class="font-bold text-gu-dark text-lg">{{ $student->name }}</h2>
                        <p class="text-sm text-gray-500 mt-0.5">{{ $student->email }}</p>

                        <div class="flex items-center justify-center gap-2 mt-4">
                            @if ($student->gpa)
                                <span class="badge-gold text-sm px-3 py-1">GPA {{ number_format($student->gpa, 1) }}</span>
                            @else
                                <span class="badge text-sm px-3 py-1 bg-gray-100 text-gray-500">No GPA set</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Roles -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="font-semibold text-gu-dark text-sm">Roles</h3>
                    </div>
                    <div class="card-body">
                        @if ($student->roles && count($student->roles) > 0)
                            <div class="flex flex-wrap gap-2">
                                @foreach ($student->roles as $role)
                                    <span class="badge-navy">{{ ucfirst(str_replace('_', ' ', $role)) }}</span>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-400">No roles specified yet.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Applications & assignments -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Assigned project -->
                @php $assigned = $student->assignedProject()->first(); @endphp
                @if ($assigned)
                    <div class="card border-green-200">
                        <div class="card-header bg-green-50">
                            <h2 class="font-semibold text-green-800">Assigned Project</h2>
                            <span class="badge-green">Confirmed</span>
                        </div>
                        <div class="card-body">
                            <a href="{{ url('projects/' . $assigned->id) }}"
                               class="font-semibold text-gu-navy hover:underline">{{ $assigned->title }}</a>
                            <p class="text-sm text-gray-500 mt-1">
                                Trimester {{ $assigned->trimester }}, {{ $assigned->year }}
                                &mdash; {{ $assigned->industryPartner->name }}
                            </p>
                        </div>
                    </div>
                @endif

                <!-- Applications -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="font-semibold text-gu-dark">Project Applications</h2>
                        <span class="badge-navy">{{ $student->applications->count() }} / 3</span>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @forelse ($student->applications as $application)
                            <div class="px-6 py-4 flex items-center justify-between">
                                <div>
                                    <a href="{{ url('projects/' . $application->id) }}"
                                       class="font-semibold text-gu-dark hover:text-gu-navy transition-colors text-sm">
                                        {{ $application->title }}
                                    </a>
                                    <p class="text-xs text-gray-400 mt-0.5">
                                        T{{ $application->trimester }} {{ $application->year }}
                                        &mdash; {{ $application->industryPartner->name }}
                                    </p>
                                    @if ($application->pivot->justification)
                                        <p class="text-xs text-gray-500 mt-1 italic">"{{ Str::limit($application->pivot->justification, 80) }}"</p>
                                    @endif
                                </div>
                                @if ($application->pivot->assigned)
                                    <span class="badge-green flex-shrink-0">Assigned</span>
                                @else
                                    <span class="badge text-xs bg-gray-100 text-gray-500 flex-shrink-0">Pending</span>
                                @endif
                            </div>
                        @empty
                            <div class="px-6 py-10 text-center">
                                <p class="text-gray-400 text-sm">No project applications yet.</p>
                                <a href="{{ url('/projects') }}" class="btn-primary btn-sm mt-3 inline-flex">Browse Projects</a>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
