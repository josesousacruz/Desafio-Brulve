import PedidoService from './PedidoService';
import { initDataTable } from './datatables';
import { criarPedido, editarPedido, excluirPedido, updateStatus } from './functions';

const service = new PedidoService();
$(function () {
    initDataTable();

    $(document).on('click', '#novoPedidoBtn', function () {
        criarPedido();
    });
    
    $(document).on('click', '.delete-btn', function () {
        const id = $(this).data('id');
        excluirPedido(id);
    });

    $(document).on('click', '.edit-btn', function () {
        const id = $(this).data('id');

        editarPedido(id);
    });

    $(document).on('click', '.up-status-btn', function () {
        const id = $(this).data('id');

        updateStatus(id);
    });
})