{{-- Componente de paginación personalizado con Tailwind --}}
@props(['paginator'])

@if ($paginator->hasPages())
    <nav aria-label="{{ __('messages.pagination') }}" class="mt-8 flex justify-center">
        {{ $paginator->links() }}
    </nav>
@endif
