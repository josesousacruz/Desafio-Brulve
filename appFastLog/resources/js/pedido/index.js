import PedidoService from './PedidoService';
import { initDataTable } from './datatables';
import { criarPedido, editarPedido, excluirPedido } from './functions';

const service = new PedidoService();
$(function () {
    initDataTable();

    $(document).on('click', '#novoPedidoBtn', function () {
        criarPedido();
    });
    // exemplo de delegação para botão de exclusão
    $(document).on('click', '.delete-btn', function () {
        const id = $(this).data('id');
        excluirPedido(id);
    });

    $(document).on('click', '.edit-btn', function () {
        const id = $(this).data('id');

        editarPedido(id);
    });

})