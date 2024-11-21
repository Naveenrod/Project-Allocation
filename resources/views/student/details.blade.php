@if(session('error'))   
<div class="container mt-4 alert alert-danger">
    {{ session('error') }}
</div>
@endif

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('PROFILE') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div>
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ $student->name }}
                        </h2>
                        <br>
                        <p class="card-text"><strong>Email:</strong> {{ $student->email }}</p>
                        @if ($student->gpa)
                            <p class="card-text"><strong>GPA:</strong> {{ $student->gpa }}</p>
                        @else
                            <p class="card-text"><strong>GPA:</strong> No GPA specified.</p>
                        @endif
                        @if ($student->roles)
                            <p><strong>Roles:</strong> {{ implode(', ', json_decode($student->roles)) }}</p>
                        @else
                            <p><strong>Roles:</strong>-</p>
                        @endif
                        @if (auth()->user() && auth()->user()->id === $student->user_id)
                        <br>
                        <div class="flex items-center gap-4">
                            <a href="{{ route('students.edit', $student->id) }}" class="btn btn-primary"><x-primary-button>{{ __('EDIT') }}</x-primary-button></a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

