import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


const page = document.body.dataset.page;

switch (page) {
    case 'usuario-index':
        import('./usuario/index')
        break;
    case 'entregador-index':
        import('./entregador/index')
        break;
    case 'pedido-index':
        import('./pedido/index')
        break;
}
