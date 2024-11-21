@if(session('error'))   
<div class="container mt-4 alert alert-danger">
    {{ session('error') }}
</div>
@endif
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('INDUSTRY PARTNER DETAILS') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container mt-5">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h3 class="font-semibold text-xl text-gray-800 leading-tight">
                                    {{ $industryPartner->name }}
                                </h3>
                                <p class="card-text"><strong>Email:</strong> {{ $industryPartner->email }}</p>
                                <br>
                                <h6 class="font-semibold text-xl text-gray-800 leading-tight">
                                    {{ __('PROJECTS') }}
                                </h6>
                                <ul class="list-group">
                                    @forelse ($industryPartner->projects as $project)
                                        <li class="list-group-item">
                                            <a href="{{ url('projects/'. $project->id) }}">{{ $project->title }}</a>
                                        </li>
                                    @empty
                                        <li class="list-group-item">No projects available.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
