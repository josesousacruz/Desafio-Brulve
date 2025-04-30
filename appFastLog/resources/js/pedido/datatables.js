export function initDataTable() {
    const table = $('#pedidos-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/pedido',
        columns: [
            { data: 'id', title: 'id' },
            { data: 'numeroPedido', title: 'Pedido' },
            { data: 'destinatarioNome', title: 'Destinatario' },
            { data: 'destinatarioEndereco', title: 'Endereço' },
            { data: 'destinatarioTelefone', title: 'Telefone' },
            { data: 'itemDescricao', title: 'Item' },
            { data: 'entregador.nome', title: 'Entregador' },
            {
                data: 'status',
                title: 'Status',
                render: function(data, type, row) {
                    let badgeClass = '';
                    let status = row.status_pedido?.status?.toLowerCase(); // protege contra null e normaliza o texto

                    switch (status) {
                        case 'criado':
                            badgeClass = 'badge bg-primary'; // Azul
                            break;
                        case 'aguardando coleta':
                            badgeClass = 'badge bg-warning text-dark'; // Amarelo
                            break;
                        case 'coleta realizada':
                            badgeClass = 'badge bg-info'; // Azul Claro
                            break;
                        case 'saiu para entrega':
                            badgeClass = 'badge bg-secondary'; // Cinza
                            break;
                        case 'entrega realizada':
                            badgeClass = 'badge bg-success'; // Verde
                            break;
                        case 'cancelado':
                            badgeClass = 'badge bg-danger'; // Vermelho
                            break;
                        default:
                            badgeClass = 'badge bg-light text-dark'; // Cinza claro para outros
                    }
            
                    return `<span class="${badgeClass}">${status}</span>`;
                }
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                className: 'text-end',
                render: function (data, type, row) {
                    return `
                        <div class="btn-group" role="group">
                            <a class="btn btn-light btn-extra-small edit-btn" data-id="${row.id}" title="Editar" type="button">
                                <i class="fas fa-pen" style="font-size: 10px;"></i>
                            </a>
                            <a class="btn btn-light btn-extra-small delete-btn" data-id="${row.id}" title="Excluir" type="button">
                                <i class="fas fa-trash" style="font-size: 10px;"></i>
                            </a>
                        </div>
                    `;
                }
            }
            
        ],
        language: {
            url: `assets/dataTable_pt-br.json`,
        },
        order: [[0, 'desc']]
    });

    return table;
}