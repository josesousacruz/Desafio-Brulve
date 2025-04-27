import moment from 'moment';
import 'moment/locale/pt-br';
moment.locale('pt-br');

export function inicializarDataTable() {
    $('#usuarios-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: '/usuario',
        language: {
            url: `assets/dataTable_pt-br.json`,
        },
        columns: [
            { data: 'id', title: 'id', orderable: false, searchable: false },
            { data: 'name', title: 'name' },
            { data: 'email', title: 'email' },
            {
                data: 'created_at',
                name: 'created_at',
                render: function (data) {
                    if (!data) return '';
                    return moment(data).format('DD/MM/YYYY HH:mm');
                }
            },
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
        ]


    });
}
