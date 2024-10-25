<footer class="bg-gray-800 text-white py-6 mb-4">
    <div class="container mx-auto text-center">
        <!-- Verifica se existe algum conteúdo no rodapé -->
        @if(\App\Models\Footer::first())
            {!! \App\Models\Footer::first()->content !!}
    
        @else
            Todos os direitos reservados.
        @endif
    </div>
</footer>
