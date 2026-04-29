<template>
    <div class="p-4 bg-white rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-800">{{ title }}</h3>
        <p class="mt-2 text-gray-600">{{ message }}</p>
    </div>
</template>
<script setup>
defineProps({
    title: { type: String, default: 'Componente Vue de ejemplo' },
    message: { type: String, default: 'Vue 3 está funcionando correctamente en este proyecto Laravel.' },
});
</script>
