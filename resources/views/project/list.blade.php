<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="section-title">Projects</h1>
                <p class="section-subtitle">Browse available WIL projects by offering period</p>
            </div>
            @if (auth()->user()->usertype === 'industry_partner')
                <a href="{{ url('/create-project') }}" class="btn-gold">+ New Project</a>
            @endif
        </div>
    </x-slot>

    <div class="page-wrapper">
        @forelse ($projects as $yearTrimester => $groupedProjects)
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-1 h-6 bg-gu-gold rounded-full"></div>
                    <h2 class="text-lg font-bold text-gu-dark">{{ $yearTrimester }}</h2>
                    <span class="badge-navy">{{ $groupedProjects->count() }} {{ Str::plural('project', $groupedProjects->count()) }}</span>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($groupedProjects as $project)
                        <a href="{{ url('projects/' . $project->id) }}"
                           class="card hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group block">
                            <div class="card-body">
                                <div class="flex items-start justify-between gap-2 mb-3">
                                    <h3 class="font-semibold text-gu-dark group-hover:text-gu-navy transition-colors leading-snug">
                                        {{ $project->title }}
                                    </h3>
                                    <span class="badge-gold flex-shrink-0">T{{ $project->trimester }}</span>
                                </div>
                                @if ($project->description)
                                    <p class="text-sm text-gray-500 line-clamp-2 mb-3">{{ $project->description }}</p>
                                @endif
                                <div class="flex items-center justify-between text-xs text-gray-400 pt-3 border-t border-gray-100">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        Team of {{ $project->team_size }}
                                    </span>
                                    <span>{{ $project->industryPartner->name ?? '—' }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="card">
                <div class="card-body text-center py-16">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-gray-500 font-medium">No projects available yet</p>
                    <p class="text-gray-400 text-sm mt-1">Projects will appear once industry partners submit them</p>
                </div>
            </div>
        @endforelse
    </div>
</x-app-layout>
