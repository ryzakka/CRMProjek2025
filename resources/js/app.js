import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// AWAL KODE UNTUK MEMAKSA LIGHT MODE
// Hapus paksa kelas 'dark' dari elemen <html> dan hapus preferensi tema dari localStorage
// Force light mode and remove any stored theme preference
if (document.documentElement.classList.contains('dark')) {
    document.documentElement.classList.remove('dark');
}
localStorage.removeItem('theme');
document.documentElement.style.setProperty('color-scheme', 'light');ocument.documentElement.style.setProperty('color-scheme', 'light'); // Tambahan untuk preferensi browser
// AKHIR KODE UNTUK MEMAKSA LIGHT MODE

Alpine.start();