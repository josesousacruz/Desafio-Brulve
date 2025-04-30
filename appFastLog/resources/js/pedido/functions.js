import PedidoService from './PedidoService';
import Swal from 'sweetalert2';
import { Offcanvas } from 'bootstrap';
import EntregadorService from '../entregador/EntregadorService';

const pedidoService = new PedidoService();
const entregadorService = new EntregadorService();

export const criarPedido = () => {

    const formHtml = `
        <form id="form-criar-pedido" class="d-flex flex-column h-100">
            <div class="flex-grow-1">
                <div class="mb-3 text-start">
                    <label for="input-numeroPedido" class="form-label">Número do Pedido <span class="text-danger">*</span></label>
                    <input id="input-numeroPedido" name="numeroPedido" class="form-control" placeholder="Ex: PED123456">
                </div>
                <div class="mb-3 text-start">
                    <label for="input-destinatarioNome" class="form-label">Nome do Destinatário <span class="text-danger">*</span></label>
                    <input id="input-destinatarioNome" name="destinatarioNome" class="form-control" placeholder="Nome completo do destinatário">
                </div>
                <div class="mb-3 text-start">
                    <label for="input-destinatarioEndereco" class="form-label">Endereço do Destinatário <span class="text-danger">*</span></label>
                    <input id="input-destinatarioEndereco" name="destinatarioEndereco" class="form-control" placeholder="Endereço completo">
                </div>
                <div class="mb-3 text-start">
                    <label for="input-destinatarioTelefone" class="form-label">Telefone do Destinatário <span class="text-danger">*</span></label>
                    <input id="input-destinatarioTelefone" name="destinatarioTelefone" class="form-control" placeholder="(00) 00000-0000">
                </div>
                <div class="mb-3 text-start">
                    <label for="input-itemDescricao" class="form-label">Descrição do Item <span class="text-danger">*</span></label>
                    <input id="input-itemDescricao" name="itemDescricao" class="form-control" placeholder="Ex: 1x Notebook Dell Inspiron">
                </div>
            
                <div class="mb-3 text-start">
                    <label for="input-entregador" class="form-label">Tipo Veiculo <span class="text-danger">*</span></label>
                    <select id="input-tipo-veiculo" name="tipo_veiculo_id" class="form-control">
                        <option value="">Selecione um veiculo</option>
                    </select>
                </div>
            </div>

            <div class="mt-3 d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-primary">Cadastrar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Cancelar</button>
            </div>
        </form>
    `;

    document.getElementById('OffcanvasLabel').innerText = 'Cadastrar Pedido';
    document.getElementById('OffcanvasContent').innerHTML = formHtml;

    const offcanvasElement = document.getElementById('Offcanvas');
    const offcanvas = new Offcanvas(offcanvasElement);
    offcanvas.show();

    // Carregar lista de entregadores
    pedidoService.tipoVeiculo()
        .then(response => {

            const select = document.getElementById('input-tipo-veiculo');
            response.data.forEach(tipoVeiculo => {
                const option = document.createElement('option');
                option.value = tipoVeiculo.id;
                option.textContent = tipoVeiculo.tipo;

                select.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Erro ao carregar entregadores:', error);
            Swal.fire('Erro!', 'Não foi possível carregar a lista de entregadores.', 'error');
        });

    document.getElementById('form-criar-pedido').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(e.target);
        const data = Object.fromEntries(formData);
        console.log(data);

        if (!data.numeroPedido || !data.destinatarioNome || !data.destinatarioEndereco ||
            !data.destinatarioTelefone || !data.itemDescricao || !data.tipo_veiculo_id) {
            Swal.fire('Atenção!', 'Preencha todos os campos obrigatórios.', 'warning');
            return;
        }

        pedidoService.criar(data)
            .then(() => {
                offcanvas.hide();
                Swal.fire('Sucesso!', 'Pedido cadastrado com sucesso.', 'success');
                $('#pedidos-table').DataTable().ajax.reload();
            })
            .catch(error => {
                console.error(error);
                if (error.response && error.response.data.errors) {
                    const mensagens = Object.values(error.response.data.errors).flat().join('<br>');
                    Swal.fire('Erro de Validação', mensagens, 'error');
                } else {
                    Swal.fire('Erro!', 'Erro ao cadastrar o pedido.', 'error');
                }
            });
    });
};

export const editarPedido = async (id) => {
    try {
        const response = await pedidoService.buscar(id);
        const pedido = response.data;
        console.log(pedido);

        const formHtml = `
            <form id="form-editar-pedido" class="d-flex flex-column h-100">
                <div class="flex-grow-1">
                    <div class="mb-3 text-start">
                        <label for="input-numeroPedido" class="form-label">Número do Pedido <span class="text-danger">*</span></label>
                        <input id="input-numeroPedido" name="numeroPedido" class="form-control" value="${pedido.numeroPedido}" placeholder="Ex: PED123456">
                    </div>
                    <div class="mb-3 text-start">
                        <label for="input-destinatarioNome" class="form-label">Nome do Destinatário <span class="text-danger">*</span></label>
                        <input id="input-destinatarioNome" name="destinatarioNome" class="form-control" value="${pedido.destinatarioNome}" placeholder="Nome completo do destinatário">
                    </div>
                    <div class="mb-3 text-start">
                        <label for="input-destinatarioEndereco" class="form-label">Endereço do Destinatário <span class="text-danger">*</span></label>
                        <input id="input-destinatarioEndereco" name="destinatarioEndereco" class="form-control" value="${pedido.destinatarioEndereco}" placeholder="Endereço completo">
                    </div>
                    <div class="mb-3 text-start">
                        <label for="input-destinatarioTelefone" class="form-label">Telefone do Destinatário <span class="text-danger">*</span></label>
                        <input id="input-destinatarioTelefone" name="destinatarioTelefone" class="form-control" value="${pedido.destinatarioTelefone}" placeholder="(00) 00000-0000">
                    </div>
                    <div class="mb-3 text-start">
                        <label for="input-itemDescricao" class="form-label">Descrição do Item <span class="text-danger">*</span></label>
                        <input id="input-itemDescricao" name="itemDescricao" class="form-control" value="${pedido.itemDescricao}" placeholder="Ex: 1x Notebook Dell Inspiron">
                    </div>
                    <div class="mb-3 text-start">
                        <label for="input-status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select id="input-status" name="status_pedido_id" class="form-control">
                            <option value="">Selecione um status</option>
                        </select>
                    </div>
                    <div class="mb-3 text-start">
                    <label for="input-entregador" class="form-label">Tipo Veiculo <span class="text-danger">*</span></label>
                    <select id="input-tipo-veiculo" name="tipo_veiculo_id" class="form-control">
                        <option value="">Selecione um veiculo</option>
                    </select>
                    </div>
                    <div class="mb-3 text-start">
                        <label for="input-entregador" class="form-label">Entregador <span class="text-danger">*</span></label>
                        <select id="input-entregador" name="entregador_id" class="form-control">
                            <option value="">Selecione um entregador</option>
                        </select>
                    </div>
                </div>

                <div class="mt-3 d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Cancelar</button>
                </div>
            </form>
        `;

        document.getElementById('OffcanvasLabel').innerText = 'Editar Pedido';
        document.getElementById('OffcanvasContent').innerHTML = formHtml;

        const offcanvas = new Offcanvas(document.getElementById('Offcanvas'));
        offcanvas.show();


        pedidoService.statusPedido()
            .then(response => {
                const select = document.getElementById('input-status');
                response.data.forEach(status => {
                    const option = document.createElement('option');
                    option.value = status.id;
                    option.textContent = status.status;
                    if (pedido.status_pedido_id === status.id) {
                        option.selected = true;
                    }
                    select.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Erro ao carregar status do pedido:', error);
                Swal.fire('Erro!', 'Não foi possível carregar a lista de status.', 'error');
            });

        // Carregar lista de tipos de veículo
        pedidoService.tipoVeiculo()
            .then(response => {
                const select = document.getElementById('input-tipo-veiculo');
                response.data.forEach(tipoVeiculo => {
                    const option = document.createElement('option');
                    option.value = tipoVeiculo.id;
                    option.textContent = tipoVeiculo.tipo;
                    if (pedido.tipo_veiculo_id === tipoVeiculo.id) {
                        option.selected = true;
                    }
                    select.appendChild(option);
                });

                // Carregar entregadores disponíveis baseado no tipo de veículo selecionado
                const tipoVeiculoId = select.value;
                if (tipoVeiculoId && pedido.status_pedido_id == 1) {
                    pedidoService.entregadoresDisponivel(tipoVeiculoId)
                        .then(response => {
                            const entregadorSelect = document.getElementById('input-entregador');
                            entregadorSelect.innerHTML = '<option value="">Selecione um entregador</option>';
                            response.data.forEach(entregador => {
                                const option = document.createElement('option');
                                option.value = entregador.id;
                                option.textContent = entregador.nome;
                                if (pedido.entregador_id === entregador.id) {
                                    option.selected = true;
                                }
                                entregadorSelect.appendChild(option);
                            });
                        })
                        .catch(error => {
                            console.error('Erro ao carregar entregadores:', error);
                            Swal.fire('Erro!', 'Não foi possível carregar a lista de entregadores.', 'error');
                        });
                }

                // Adicionar evento de mudança para atualizar lista de entregadores
                select.addEventListener('change', function() {
                    const tipoVeiculoId = this.value;
                    if (tipoVeiculoId) {
                        pedidoService.entregadoresDisponivel(tipoVeiculoId)
                            .then(response => {
                                const entregadorSelect = document.getElementById('input-entregador');
                                entregadorSelect.innerHTML = '<option value="">Selecione um entregador</option>';
                                response.data.forEach(entregador => {
                                    const option = document.createElement('option');
                                    option.value = entregador.id;
                                    option.textContent = entregador.nome;
                                    entregadorSelect.appendChild(option);
                                });
                            })
                            .catch(error => {
                                console.error('Erro ao carregar entregadores:', error);
                                Swal.fire('Erro!', 'Não foi possível carregar a lista de entregadores.', 'error');
                            });
                    } else {
                        const entregadorSelect = document.getElementById('input-entregador');
                        entregadorSelect.innerHTML = '<option value="">Selecione um entregador</option>';
                    }
                });
            })
            .catch(error => {
                console.error('Erro ao carregar tipos de veículo:', error);
                Swal.fire('Erro!', 'Não foi possível carregar a lista de tipos de veículo.', 'error');
            });

        // Carregar lista de entregadores
        entregadorService.listar()
            .then(response => {
                const select = document.getElementById('input-entregador');
                console.log(response);

                response.data.data.forEach(entregador => {
                    const option = document.createElement('option');
                    option.value = entregador.id;
                    option.textContent = entregador.nome;
                    if (pedido.entregador_id === entregador.id) {
                        option.selected = true;
                    }
                    select.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Erro ao carregar entregadores:', error);
                Swal.fire('Erro!', 'Não foi possível carregar a lista de entregadores.', 'error');
            });

        document.getElementById('form-editar-pedido').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData);



            if (!data.numeroPedido || !data.destinatarioNome || !data.destinatarioEndereco ||
                !data.destinatarioTelefone || !data.itemDescricao || !data.entregador_id) {
                Swal.fire('Atenção!', 'Preencha todos os campos obrigatórios.', 'warning');
                return;
            }

            pedidoService.atualizar(id, data)
                .then(() => {
                    offcanvas.hide();
                    Swal.fire('Sucesso!', 'Pedido atualizado com sucesso.', 'success');
                    $('#pedidos-table').DataTable().ajax.reload();
                })
                .catch(error => {
                    console.error(error);
                    Swal.fire('Erro!', 'Erro ao atualizar o pedido.', 'error');
                });


        });

    } catch (error) {
        console.error(error);
        Swal.fire('Erro!', 'Não foi possível carregar os dados do pedido.', 'error');
    }
};

export const excluirPedido = (id) => {
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
            pedidoService.excluir(id)
                .then(() => {
                    Swal.fire('Excluído!', 'O pedido foi excluído com sucesso.', 'success');
                    $('#pedidos-table').DataTable().ajax.reload();
                })
                .catch(error => {
                    console.error(error);
                    Swal.fire('Erro!', 'Erro ao excluir o pedido.', 'error');
                });
        }
    });
};

export const atualizarStatusPedido = (id, status) => {
    pedidoService.atualizarStatus(id, status)
        .then(() => {
            Swal.fire('Sucesso!', 'Status do pedido atualizado com sucesso.', 'success');
            $('#pedidos-table').DataTable().ajax.reload();
        })
        .catch(error => {
            console.error(error);
            Swal.fire('Erro!', 'Erro ao atualizar o status do pedido.', 'error');
        });
};

export const updateStatus = (id) => {
    pedidoService.atualizarStatus(id)
       .then(() => {
            Swal.fire('Sucesso!', 'Status do pedido atualizado com sucesso.','success');
            $('#pedidos-table').DataTable().ajax.reload();
        })
       .catch(error => {
            console.error(error);
            Swal.fire('Erro!', 'Erro ao atualizar o status do pedido.', 'error');
       })
    console.log(id);
    
}