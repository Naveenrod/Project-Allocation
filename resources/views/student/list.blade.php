@if(session('error'))
<div class="container mt-4 alert alert-danger">
    {{ session('error') }}
</div>
@endif

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('STUDENTS') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <ul class="list-group">
                        @foreach($students as $student)
                            <li>
                                <h5 class="font-semibold">
                                    {{ $student->name }}
                                </h5>
                                <a href="{{ route('students.show', $student->id) }}" class="btn btn-primary btn-sm float-end"><x-primary-button>View Profile</a></x-primary-button>
                            </li>
                            <br>
                        @endforeach
                    </ul>
                    <div>
                        <form method="POST" action="{{ route('auto-assign') }}">
                            @csrf
                            <input type="hidden" name="year" value="{{ $student->id }}"> 
                            <input type="hidden" name="trimester" value="{{ $student->id }}"> 
                            <button type="submit" class="btn btn-primary btn-sm float-end">AUTO ASSIGN</button>
                        </form>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>
</x-app-layout>

