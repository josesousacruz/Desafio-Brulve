export function initDataTable() {
    const table = $('#pedidos-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/pedidos/data',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'cliente', name: 'cliente' },
            { data: 'entregador', name: 'entregador' },
            { data: 'endereco_entrega', name: 'endereco_entrega' },
            { data: 'status', name: 'status' },
            { data: 'data_entrega', name: 'data_entrega' },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json'
        },
        order: [[0, 'desc']]
    });

    return table;
}