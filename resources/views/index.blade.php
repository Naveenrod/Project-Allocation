<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="section-title">Industry Partners</h1>
            <p class="section-subtitle">Companies and organisations offering WIL projects</p>
        </div>
    </x-slot>

    <div class="page-wrapper">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($industryPartners as $partner)
                <a href="{{ url('industry-partners/' . $partner->id) }}"
                   class="card hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group block">
                    <div class="card-body">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-gu-navy flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                                {{ strtoupper(substr($partner->name, 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <h3 class="font-semibold text-gu-dark group-hover:text-gu-navy transition-colors truncate">
                                    {{ $partner->name }}
                                </h3>
                                <p class="text-xs text-gray-400 mt-0.5 truncate">{{ $partner->email }}</p>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-400">
                            <span>{{ $partner->projects->count() }} {{ Str::plural('project', $partner->projects->count()) }}</span>
                            @if ($partner->approved)
                                <span class="badge-green">Approved</span>
                            @else
                                <span class="badge-red">Pending approval</span>
                            @endif
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full card">
                    <div class="card-body text-center py-16">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <p class="text-gray-500 font-medium">No industry partners yet</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($industryPartners->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $industryPartners->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
