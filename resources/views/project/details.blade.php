@if(session('error'))
<div class="container mt-4 alert alert-danger">
    {{ session('error') }}
</div>
@endif
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('PROJECT DETAILS') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h4 class="font-semibold text-xl text-gray-800 leading-tight">
                               {{ $project->title }}
                            </h4>
                            <br>
                            <p class="card-text"><strong>Description:</strong> {{ $project->description }}</p>
                            <p class="card-text"><strong>Team Size:</strong> {{ $project->team_size }}</p>
                            <p class="card-text"><strong>Trimester:</strong> {{ $project->trimester }}</p>
                            <p class="card-text"><strong>Year:</strong> {{ $project->year }}</p>
                            <p><strong>Offered by:</strong>  {{ $project->industryPartner->name }}</h6>
                            @if (auth()->user()->usertype === 'student')
                                <div class="flex items-center gap-4">
                                    <a href="{{ url('projects/' . $project->id . '/apply')}}" class="btn btn-primary"><x-primary-button>{{ __('APPLY') }}</x-primary-button></a>
                                </div>

                            @elseif (auth()->user()->usertype === 'industry_partner')
                                <div>
                                    <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-success"><x-primary-button>{{ __('EDIT') }}</x-primary-button></a>
                                    <form action="{{ route('projects.destroy', $project->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <x-primary-button>{{ __('DELETE') }}</x-primary-button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <br>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="font-semibold">Applicants</h5>
                            @if ($project->applicants->count() > 0)
                                <ul class="list-group">
                                    @foreach ($project->applicants as $applicant)
                                        <li class="list-group-item"><strong>{{ $applicant->name }}</strong> - {{ $applicant->pivot->justification }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p>No applications for this project yet.</p>
                            @endif
                        </div>
                    </div>

                    <br>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="font-semibold">Images</h5>
                            @if ($project->files->count() > 0)
                                <ul class="list-group">
                                    @foreach ($project->files->where('file_type', 'image') as $image)
                                        <li class="list-group-item">
                                            <img src="{{ url($image->file_path) }}" alt="{{ $image->file_path }}" style="width:300px;height:200px;">
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p>No images</p>
                            @endif
                        </div>
                    </div>
                    <br>

                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="font-semibold">PDF Files</h5>
                            @if ($project->files->count() > 0)
                                <ul class="list-group">
                                    @foreach ($project->files->where('file_type', 'pdf') as $pdf)
                                        <li class="list-group-item">
                                            <a href="{{ asset('storage/' . $pdf->file_path) }}" target="_blank" rel="noopener noreferrer">{{ $pdf->file_path }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p>No PDF files</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
