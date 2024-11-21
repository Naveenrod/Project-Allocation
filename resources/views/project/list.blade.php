@if(session('error'))   
        <div class="container mt-4 alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('PROJECT LIST') }}
            </h2>
        </x-slot>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        @foreach ($projects as $yearTrimester => $groupedProjects)
                            <div class="mb-4">
                                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                    {{ $yearTrimester }}
                                </h2>
                                <ul class="list-group">
                                    @foreach ($groupedProjects as $project)
                                        <li class="list-group-item">
                                            <a href="{{ url('projects/'. $project->id) }}" class="text-decoration-none">
                                                {{ $project->title }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>   

