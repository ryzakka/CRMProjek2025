import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// KODE UNTUK MEMAKSA LIGHT MODE (dari sebelumnya)
if (document.documentElement.classList.contains('dark')) {
    document.documentElement.classList.remove('dark');
}
localStorage.removeItem('theme');
document.documentElement.style.setProperty('color-scheme', 'light');

Alpine.start(); // <-- INISIALISASI ALPINE.JS