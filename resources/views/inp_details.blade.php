<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
            <a href="{{ url('/') }}" class="hover:text-gu-navy transition-colors">Industry Partners</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gu-dark font-medium">{{ $industryPartner->name }}</span>
        </div>
        <h1 class="section-title">{{ $industryPartner->name }}</h1>
        <p class="section-subtitle">Industry Partner Profile</p>
    </x-slot>

    <div class="page-wrapper">
        <div class="grid gap-6 lg:grid-cols-3">

            <!-- Sidebar info -->
            <div class="space-y-5">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="w-20 h-20 rounded-2xl bg-gu-navy flex items-center justify-center text-white font-bold text-3xl mx-auto mb-4">
                            {{ strtoupper(substr($industryPartner->name, 0, 1)) }}
                        </div>
                        <h2 class="font-bold text-gu-dark text-lg">{{ $industryPartner->name }}</h2>
                        <p class="text-sm text-gray-500 mt-0.5">{{ $industryPartner->email }}</p>
                        <div class="mt-3">
                            @if ($industryPartner->approved)
                                <span class="badge-green">Approved Partner</span>
                            @else
                                <span class="badge-red">Pending Approval</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <p class="text-3xl font-bold text-gu-navy">{{ $industryPartner->projects->count() }}</p>
                            <p class="text-sm text-gray-500 mt-0.5">{{ Str::plural('Project', $industryPartner->projects->count()) }} listed</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Projects list -->
            <div class="lg:col-span-2">
                <div class="card">
                    <div class="card-header">
                        <h2 class="font-semibold text-gu-dark">Projects</h2>
                        <span class="badge-navy">{{ $projects->count() }}</span>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @forelse ($projects as $project)
                            <a href="{{ url('projects/' . $project->id) }}"
                               class="flex items-center justify-between px-6 py-4 hover:bg-gu-light transition-colors group">
                                <div>
                                    <p class="font-semibold text-gu-dark group-hover:text-gu-navy transition-colors text-sm">
                                        {{ $project->title }}
                                    </p>
                                    <p class="text-xs text-gray-400 mt-0.5">
                                        Trimester {{ $project->trimester }}, {{ $project->year }}
                                        &bull; Team of {{ $project->team_size }}
                                    </p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="badge-gold">T{{ $project->trimester }}</span>
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </div>
                            </a>
                        @empty
                            <div class="px-6 py-12 text-center">
                                <p class="text-gray-400 text-sm">No projects submitted yet.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
