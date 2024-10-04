<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Received Adoption Forms') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if ($adoptionForms->isEmpty())
                    <p>No adoption forms have been received yet.</p>
                @else
                    @foreach ($adoptionForms as $adoptionForm)
                        <div class="mb-4">
                            <h3>Adoption Form for {{ $adoptionForm->pet->name }}</h3>
                            <p>{{ $adoptionForm->motivation }}</p>
                            <div class="flex space-x-4">
                                <form action="{{ route('adoption-form.update-status', ['adoptionForm' => $adoptionForm->id, 'status' => 'approved']) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <x-button class="ml-4 bg-green-500">
                                        {{ __('Approve') }}
                                    </x-button>
                                </form>
                                <form action="{{ route('adoption-form.update-status', ['adoptionForm' => $adoptionForm->id, 'status' => 'rejected']) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <x-button class="ml-4 bg-red-500">
                                        {{ __('Reject') }}
                                    </x-button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
