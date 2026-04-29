import './bootstrap';
import Alpine from 'alpinejs';
import { createApp } from 'vue';

window.Alpine = Alpine;
Alpine.start();

// Vue 3
const vueApp = createApp({});
const components = import.meta.glob('./components/**/*.vue', { eager: true });
Object.entries(components).forEach(([path, component]) => {
    const name = path.split('/').pop().replace('.vue', '');
    vueApp.component(name, component.default);
});
const vueRoot = document.getElementById('vue-app');
if (vueRoot) {
    vueApp.mount('#vue-app');
}
