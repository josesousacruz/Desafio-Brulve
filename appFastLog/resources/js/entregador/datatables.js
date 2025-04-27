export function initDataTable() {
    const table = $('#entregadores-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/entregador',
        columns: [
            { data: 'id', title: 'id' },
            { data: 'nome', title: 'nome' },
            // { data: 'cpf', name: 'cpf' },
            { data: 'telefone', title: 'telefone' },
            // { data: 'status', name: 'status' },
            {
                data: null,
                orderable: false,
                searchable: false,
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
    });

    return table;
}