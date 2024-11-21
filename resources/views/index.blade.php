@if (session('error'))
    <div class="container mt-4 alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('INDUSTRY PARTNERS') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @foreach ($industryPartners as $partner)
                        <li class="mb-3">
                            <a href="{{ url('industry-partners/'. $partner->id) }}" class="text-decoration-none display-4">
                                {{ $partner->name }}
                            </a>
                        </li>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Horizontal alignment of pagination links using inline CSS -->
    <div style="display: flex; justify-content: center; align-items: center; margin-top: 20px;">
        {{ $industryPartners->links() }}
    </div>
</x-app-layout>
