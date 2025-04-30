import $ from 'jquery';
window.$ = window.jQuery = $; 
globalThis.$ = globalThis.jQuery = $; 

// Garante que o jQuery está disponível globalmente antes de carregar o Bootstrap
if (typeof window.jQuery === 'undefined') {
    console.error('jQuery não está disponível globalmente');
}

import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import 'bootstrap-icons/font/bootstrap-icons.css'
import 'datatables.net'; 
import 'datatables.net-bs5';
import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';

import Swal from 'sweetalert2';
import 'simplebar';
import 'simplebar/dist/simplebar.css';

import '../css/app.css';

import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
