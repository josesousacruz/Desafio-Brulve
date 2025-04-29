import EntregadorService from './EntregadorService';
import { initDataTable } from './datatables';
import { criarEntregador, editarEntregador, excluirEntregador } from './functions';

const service = new EntregadorService();

$(function () {
    initDataTable();

    $(document).on('click', '#novoEntregadorBtn', function () {
        criarEntregador();
    });
    // exemplo de delegação para botão de exclusão
    $(document).on('click', '.delete-btn', function () {
        const id = $(this).data('id');
        excluirEntregador(id);
    });

    $(document).on('click', '.edit-btn', function () {
        const id = $(this).data('id');
        
        editarEntregador(id);
    });
})