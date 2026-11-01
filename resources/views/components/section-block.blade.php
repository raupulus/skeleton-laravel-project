@props(['block'])
<section class="py-12">
    @if($block->getTranslation('title', app()->getLocale()))<h2 class="text-3xl font-bold text-gray-800 mb-4">{{ $block->getTranslation('title', app()->getLocale()) }}</h2>@endif
    @if($block->getTranslation('description', app()->getLocale()))<p class="text-gray-600 mb-6">{{ $block->getTranslation('description', app()->getLocale()) }}</p>@endif
    @if($block->getTranslation('content', app()->getLocale()))<div class="prose max-w-none">{!! $block->getTranslation('content', app()->getLocale()) !!}</div>@endif
    @if($block->image)<img src="{{ Storage::disk('public')->url($block->image) }}" alt="{{ $block->getTranslation('title', app()->getLocale()) }}" class="mt-6 rounded-lg" />@endif
</section>
