import { inicializarDataTable } from './datatables';
import { excluirUsuario, criarUsuario, editarUsuario } from './functions';

$(function () {
    inicializarDataTable();

    $(document).on('click', '#novoUsuarioBtn', function () {
        criarUsuario();
    });
    // exemplo de delegação para botão de exclusão
    $(document).on('click', '.delete-btn', function () {
        const id = $(this).data('id');
        excluirUsuario(id);
    });

    $(document).on('click', '.edit-btn', function () {
        const id = $(this).data('id');
        
        editarUsuario(id);
    });
});
