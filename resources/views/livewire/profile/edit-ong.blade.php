<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save">
        <!-- Nome da ONG -->
        <div class="col-span-6 sm:col-span-4">
            <label for="ong_name" class="block text-sm font-medium text-gray-700">Nome da ONG</label>
            <input id="ong_name" type="text" wire:model.defer="ong_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            @error('ong_name') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Nome do Responsável -->
        <div class="col-span-6 sm:col-span-4 mt-4">
            <label for="responsible_name" class="block text-sm font-medium text-gray-700">Nome do Responsável</label>
            <input id="responsible_name" type="text" wire:model.defer="responsible_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            @error('responsible_name') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- CPF do Responsável -->
        <div class="col-span-6 sm:col-span-4 mt-4">
            <label for="responsible_cpf" class="block text-sm font-medium text-gray-700">CPF do Responsável</label>
            <input id="responsible_cpf" type="text" wire:model.defer="responsible_cpf" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            @error('responsible_cpf') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- CNPJ -->
        <div class="col-span-6 sm:col-span-4 mt-4">
            <label for="cnpj" class="block text-sm font-medium text-gray-700">CNPJ</label>
            <input id="cnpj" type="text" wire:model.defer="cnpj" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            @error('cnpj') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Endereço -->
        <div class="col-span-6 sm:col-span-4 mt-4">
            <label for="address" class="block text-sm font-medium text-gray-700">Endereço</label>
            <input id="address" type="text" wire:model.defer="address" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            @error('address') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Telefone -->
        <div class="col-span-6 sm:col-span-4 mt-4">
            <label for="phone" class="block text-sm font-medium text-gray-700">Telefone</label>
            <input id="phone" type="text" wire:model.defer="phone" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            @error('phone') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Botão de Salvar -->
        <div class="col-span-6 sm:col-span-4 mt-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Salvar</button>
        </div>
    </form>
</div>
