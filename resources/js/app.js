import './bootstrap';

import Alpine from 'alpinejs';

import { setTheme } from './dark-mode';

window.Alpine = Alpine;

Alpine.start();

// Aplicar el tema al iniciar
document.addEventListener('DOMContentLoaded', setTheme);