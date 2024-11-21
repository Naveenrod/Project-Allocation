@if(session('error'))   
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
                    <h1 class="font-semibold">APPROVAL NEEDED!</h1><br>
                        <ul>
                            @foreach ($unapprovedPartners as $partner)
                            <li>
                                    <p>{{ $partner->name }}</p>
                                        <form action="{{ route('industry-partners.approve', $partner->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <x-primary-button>Approve</x-primary-button>
                                        </form>
                                    </li>
                            <br>
                            @endforeach
                        </ul>
                        
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

