import EntregadorService from './EntregadorService';
import Swal from 'sweetalert2';
import { Offcanvas } from 'bootstrap';

const entregadorService = new EntregadorService();

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

export const criarEntregador = () => {
    const formHtml = `
        <form id="form-criar-entregador" class="d-flex flex-column h-100">
            <div class="flex-grow-1">
                <div class="mb-3 text-start">
                    <label for="input-name" class="form-label">Nome <span class="text-danger">*</span></label>
                    <input id="input-name" class="form-control" placeholder="Digite o nome">
                </div>
                <div class="mb-3 text-start">
                    <label for="input-telefone" class="form-label">Telefone <span class="text-danger">*</span></label>
                    <input id="input-telefone" class="form-control" placeholder="Digite o telefone">
                </div>
                <div class="mb-3 text-start">
                    <label for="input-tipo-veiculo" class="form-label">Tipo de Veículo <span class="text-danger">*</span></label>
                    <select id="input-tipo-veiculo" class="form-select">
                        <option value="">Selecione o tipo de veículo</option>
                    </select>
                </div>
            </div>

            <div class="mt-3 d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-primary">Cadastrar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Cancelar</button>
            </div>
        </form>
    `;

    document.getElementById('OffcanvasLabel').innerText = 'Cadastrar Entregador';
    document.getElementById('OffcanvasContent').innerHTML = formHtml;

entregadorService.tipoVeiculo()
    .then(response => {
        console.log(response.data);
        
        const tipoVeiculoSelect = document.getElementById('input-tipo-veiculo');
        response.data.forEach(tipo => {
            const option = document.createElement('option');
            option.value = tipo.id;
            option.textContent = tipo.tipo;
            tipoVeiculoSelect.appendChild(option);
        });
    })
    .catch(error => {
        console.error('Error loading vehicle types:', error);
        Swal.fire('Erro!', 'Não foi possível carregar os tipos de veículo.', 'error');
    });

    const offcanvasElement = document.getElementById('Offcanvas');
    const offcanvas = new Offcanvas(offcanvasElement);
    offcanvas.show();

    document.getElementById('form-criar-entregador').addEventListener('submit', function (e) {
        e.preventDefault();

        const nome = document.getElementById('input-name').value.trim();
        const telefone = document.getElementById('input-telefone').value.trim();
        const tipoVeiculo = document.getElementById('input-tipo-veiculo').value.trim();

        if (!nome || !telefone || !tipoVeiculo) {
            Swal.fire('Atenção!', 'Preencha todos os campos obrigatórios.', 'warning');
            return;
        }

        entregadorService.criar({ nome, telefone, tipo_veiculo_id: tipoVeiculo })
            .then(() => {
                offcanvas.hide();
                Swal.fire('Sucesso!', 'Entregador cadastrado com sucesso.', 'success');
                $('#entregadores-table').DataTable().ajax.reload();
            })
            .catch(error => {
                console.error(error);
                if (error.response && error.response.data.errors) {
                    const mensagens = Object.values(error.response.data.errors).flat().join('<br>');
                    Swal.fire('Erro de Validação', mensagens, 'error');
                } else {
                    Swal.fire('Erro!', 'Erro ao cadastrar o entregador.', 'error');
                }
            });
    });
};

export const editarEntregador = async (id) => {
    try {
        const response = await entregadorService.buscar(id);
        const entregador = response.data;
        console.log(entregador);

        const formHtml = `
            <form id="form-editar-entregador" class="d-flex flex-column h-100">
                <div class="flex-grow-1">
                    <div class="mb-3 text-start">
                        <label for="input-name" class="form-label">Nome</label>
                        <input id="input-name" class="form-control" value="${entregador.nome}" placeholder="Digite o nome">
                    </div>
                    <div class="mb-3 text-start">
                        <label for="input-telefone" class="form-label">Telefone</label>
                        <input id="input-telefone" class="form-control" value="${entregador.telefone}" placeholder="Digite o telefone">
                    </div>
                    <div class="mb-3 text-start">
                        <label for="input-tipo-veiculo" class="form-label">Tipo de Veículo</label>
                        <select id="input-tipo-veiculo" class="form-select">
                            <option value="">Selecione o tipo de veículo</option>
                        </select>
                    </div>
                </div>

                <div class="mt-3 d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Cancelar</button>
                </div>
            </form>
        `;

        document.getElementById('OffcanvasLabel').innerText = 'Editar Entregador';
        document.getElementById('OffcanvasContent').innerHTML = formHtml;

        const offcanvas = new Offcanvas(document.getElementById('Offcanvas'));
        offcanvas.show();

        // Carregar tipos de veículo
        entregadorService.tipoVeiculo()
            .then(response => {
                const tipoVeiculoSelect = document.getElementById('input-tipo-veiculo');
                response.data.forEach(tipo => {
                    const option = document.createElement('option');
                    option.value = tipo.id;
                    option.textContent = tipo.tipo;
                    if (entregador.tipo_veiculo_id === tipo.id) {
                        option.selected = true;
                    }
                    tipoVeiculoSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error loading vehicle types:', error);
                Swal.fire('Erro!', 'Não foi possível carregar os tipos de veículo.', 'error');
            });

        document.getElementById('form-editar-entregador').addEventListener('submit', function (e) {
            e.preventDefault();

            const nome = document.getElementById('input-name').value.trim();
            const telefone = document.getElementById('input-telefone').value.trim();
            const tipoVeiculo = document.getElementById('input-tipo-veiculo').value.trim();

            if (!nome || !telefone || !tipoVeiculo) {
                Swal.fire('Atenção!', 'Preencha todos os campos obrigatórios.', 'warning');
                return;
            }

            entregadorService.atualizar(id, { nome, telefone, tipo_veiculo_id: tipoVeiculo })
                .then(() => {
                    offcanvas.hide();
                    Swal.fire('Sucesso!', 'Entregador atualizado com sucesso.', 'success');
                    $('#entregadores-table').DataTable().ajax.reload();
                })
                .catch(error => {
                    console.error(error);
                    if (error.response && error.response.data.errors) {
                        const mensagens = Object.values(error.response.data.errors).flat().join('<br>');
                        Swal.fire('Erro de Validação', mensagens, 'error');
                    } else {
                        Swal.fire('Erro!', 'Erro ao atualizar o entregador.', 'error');
                    }
                });
        });

    } catch (error) {
        console.error(error);
        Swal.fire('Erro!', 'Não foi possível carregar os dados do entregador.', 'error');
    }
};

export const excluirEntregador = (id) => {
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
            entregadorService.deletar(id)
                .then(() => {
                    Swal.fire('Excluído!', 'O entregador foi excluído com sucesso.', 'success');
                    $('#entregadores-table').DataTable().ajax.reload();
                })
                .catch(error => {

                    let mensagemErro = 'Erro ao excluir o entregador.';
                    if (error.response && error.response.data && error.response.data.message) {
                        mensagemErro = error.response.data.message;
                    }

                    Swal.fire('Erro!', mensagemErro, 'error');
                });
        }
    });
};