@if(session('error'))   
    <div class="container mt-4 alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('APPLY') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ url('/application/' . $project->id) }}">
                        @csrf
                        <!-- Justification -->
                        <div class="mb-3">
                            <x-input-label for="justification" :value="__('JUSTIFICATION (REASON TO APPLY THIS PROJECT)')" />
                            <x-text-input id="justification" name="justification" type="text" required class="mt-1 block w-full" value="{{ old('justification') }}" />
                        </div>
                        <br>
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('SUBMIT') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
        
