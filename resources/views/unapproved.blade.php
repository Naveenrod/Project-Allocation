<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="section-title">Pending Approvals</h1>
            <p class="section-subtitle">Industry partners awaiting teacher approval before they can post projects</p>
        </div>
    </x-slot>

    <div class="page-wrapper max-w-3xl mx-auto">
        @if ($unapprovedPartners->isEmpty())
            <div class="card">
                <div class="card-body text-center py-16">
                    <svg class="w-12 h-12 text-green-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-gray-500 font-medium">All caught up!</p>
                    <p class="text-gray-400 text-sm mt-1">No industry partners are waiting for approval.</p>
                </div>
            </div>
        @else
            <div class="card">
                <div class="card-header">
                    <h2 class="font-semibold text-gu-dark">Awaiting Approval</h2>
                    <span class="badge-red">{{ $unapprovedPartners->count() }} pending</span>
                </div>
                <div class="divide-y divide-gray-100">
                    @foreach ($unapprovedPartners as $partner)
                        <div class="flex items-center justify-between px-6 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-gu-navy/10 flex items-center justify-center text-gu-navy font-bold flex-shrink-0">
                                    {{ strtoupper(substr($partner->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gu-dark">{{ $partner->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $partner->email }}</p>
                                </div>
                            </div>
                            <form action="{{ route('industry-partners.approve', $partner->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn-gold btn-sm"
                                    onclick="return confirm('Approve {{ $partner->name }} as an industry partner?')">
                                    Approve
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
