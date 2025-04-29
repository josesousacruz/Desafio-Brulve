import UsuarioService from './UsuarioService';
import Swal from 'sweetalert2';
import { Offcanvas } from'bootstrap';

const usuarioService = new UsuarioService();

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

export const criarUsuario = () => {
    // Montar o formulário
    const formHtml = `
        <form id="form-criar-usuario" class="d-flex flex-column h-100">
            <div class="flex-grow-1">
                <div class="mb-3 text-start">
                    <label for="input-name" class="form-label">Nome <span class="text-danger">*</span></label>
                    <input id="input-name" class="form-control" placeholder="Digite o nome">
                </div>
                <div class="mb-3 text-start">
                    <label for="input-email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input id="input-email" type="email" class="form-control" placeholder="Digite o email">
                </div>
                <div class="mb-3 text-start">
                    <label for="input-password" class="form-label">Senha <span class="text-danger">*</span></label>
                    <input id="input-password" type="password" class="form-control" placeholder="Digite a senha">
                </div>
                <div class="mb-3 text-start">
                    <label for="input-password-confirmation" class="form-label">Confirme a Senha <span class="text-danger">*</span></label>
                    <input id="input-password-confirmation" type="password" class="form-control" placeholder="Confirme a senha">
                </div>
            </div>

            <div class="mt-3 d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-primary">Cadastrar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Cancelar</button>
            </div>
        </form>
    `;

    // Injetar conteúdo
    document.getElementById('OffcanvasLabel').innerText = 'Cadastrar Usuário';
    document.getElementById('OffcanvasContent').innerHTML = formHtml;

    // Abrir o Offcanvas
    const offcanvasElement = document.getElementById('Offcanvas');
    const offcanvas = new Offcanvas(offcanvasElement);
    offcanvas.show();

    // Evento submit do formulário
    document.getElementById('form-criar-usuario').addEventListener('submit', function(e) {
        e.preventDefault();

        const name = document.getElementById('input-name').value.trim();
        const email = document.getElementById('input-email').value.trim();
        const password = document.getElementById('input-password').value.trim();
        const passwordConfirmation = document.getElementById('input-password-confirmation').value.trim();

        if (!name || !email || !password || !passwordConfirmation) {
            Swal.fire('Atenção!', 'Preencha todos os campos obrigatórios.', 'warning');
            return;
        }

        if (password !== passwordConfirmation) {
            Swal.fire('Erro!', 'As senhas não conferem.', 'error');
            return;
        }

        usuarioService.criar({ name, email, password, password_confirmation: passwordConfirmation })
            .then(() => {
                offcanvas.hide();
                Swal.fire('Sucesso!', 'Usuário cadastrado com sucesso.', 'success');
                $('#usuarios-table').DataTable().ajax.reload();
            })
            .catch(error => {
                console.error(error);
                if (error.response && error.response.data.errors) {
                    const mensagens = Object.values(error.response.data.errors).flat().join('<br>');
                    Swal.fire('Erro de Validação', mensagens, 'error');
                } else {
                    Swal.fire('Erro!', 'Erro ao cadastrar o usuário.', 'error');
                }
            });
    });
};

export const editarUsuario = async (id) => {
    try {
        const response = await usuarioService.buscar(id);
        const usuario = response.data;

        const formHtml = `
            <form id="form-editar-usuario" class="add-new-user pt-0 fv-plugins-bootstrap5 fv-plugins-framework flex-grow-1 d-flex flex-column">
                <div class="mb-3 text-start">
                    <label for="input-name" class="form-label">Nome</label>
                    <input id="input-name" class="form-control" value="${usuario.name}" placeholder="Digite o nome">
                </div>
                <div class="mb-3 text-start">
                    <label for="input-email" class="form-label">Email</label>
                    <input id="input-email" type="email" class="form-control" value="${usuario.email}" placeholder="Digite o email">
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        `;

        // Inserir o conteúdo
        document.getElementById('OffcanvasLabel').innerText = 'Editar Usuário';
        document.getElementById('OffcanvasContent').innerHTML = formHtml;

        // Abrir o Offcanvas
        const offcanvas = new Offcanvas(document.getElementById('Offcanvas'));
        offcanvas.show();

        // Handle submit
        document.getElementById('form-editar-usuario').addEventListener('submit', function(e) {
            e.preventDefault();

            const name = document.getElementById('input-name').value.trim();
            const email = document.getElementById('input-email').value.trim();

            if (!name || !email) {
            
                Swal.fire('Erro!', 'Preencha todos os campos!', 'error');
                return;
            }

            usuarioService.atualizar(id, { name, email })
                .then(() => {
                    offcanvas.hide();
                    Swal.fire(
                        'Sucesso!',
                        'Usuário atualizado com sucesso.',
                        'success'
                    );
                    $('#usuarios-table').DataTable().ajax.reload();
                })
                .catch(error => {
                    console.error(error);
                    Swal.fire(
                        'Erro!',
                        'Erro ao atualizar o usuário.',
                        'error'
                    );
                });
        });

    } catch (error) {
        console.error(error);
        Swal.fire(
            'Erro!',
            'Não foi possível carregar os dados do usuário.',
            'error'
        );
    }
};

export const excluirUsuario = (id) => {
    Swal.fire({
        title: 'Tem certeza?',
        text: 'Esta ação não poderá ser desfeita!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            usuarioService.deletar(id)
                .then(() => {
                    Swal.fire(
                        'Excluído!',
                        'O usuário foi excluído com sucesso.',
                        'success'
                    );
                    $('#usuarios-table').DataTable().ajax.reload();
                })
                .catch(error => {
                    console.error(error);
                    Swal.fire(
                        'Erro!',
                        'Erro ao excluir o usuário.',
                        'error'
                    );
                });
        }
    });
};
