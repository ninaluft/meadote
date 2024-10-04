<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Chat with {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div id="chat-window" class="mb-4 h-96 overflow-y-auto">
                    <!-- Existing messages will be loaded here by fetchMessages -->
                </div>

                <form id="message-form">
                    @csrf
                    <input type="hidden" id="recipient-id" value="{{ $user->id }}">
                    <div class="flex">
                        <input type="text" id="message-input" class="flex-grow px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Type your message" required>
                        <button type="submit" class="ml-4 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Send
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const userId = {{ Auth::id() }};
        const recipientId = {{ $user->id }};
    </script>
</x-app-layout>
