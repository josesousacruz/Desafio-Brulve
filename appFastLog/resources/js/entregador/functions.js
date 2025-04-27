export function initEvents(service) {
    const form = document.querySelector('#entregador-form');
    const modal = document.querySelector('#entregador-modal');

    document.querySelector('#novo-entregador').addEventListener('click', () => {
        form.reset();
        form.dataset.mode = 'create';
        delete form.dataset.id;
    });

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);

        try {
            if (form.dataset.mode === 'edit') {
                await service.atualizar(form.dataset.id, data);
            } else {
                await service.criar(data);
            }

            bootstrap.Modal.getInstance(modal).hide();
            $('#entregadores-table').DataTable().ajax.reload();
            toastr.success('Operação realizada com sucesso!');
        } catch (error) {
            toastr.error('Erro ao processar operação.');
            console.error(error);
        }
    });

    document.addEventListener('click', async (e) => {
        if (e.target.matches('[data-edit]')) {
            const id = e.target.dataset.edit;
            const response = await fetch(`/entregadores/${id}/edit`);
            const data = await response.json();

            Object.keys(data).forEach(key => {
                const input = form.querySelector(`[name=${key}]`);
                if (input) input.value = data[key];
            });

            form.dataset.mode = 'edit';
            form.dataset.id = id;
            bootstrap.Modal.getInstance(modal).show();
        }

        if (e.target.matches('[data-delete]')) {
            if (confirm('Confirma a exclusão?')) {
                try {
                    await service.excluir(e.target.dataset.delete);
                    $('#entregadores-table').DataTable().ajax.reload();
                    toastr.success('Entregador excluído com sucesso!');
                } catch (error) {
                    toastr.error('Erro ao excluir entregador.');
                    console.error(error);
                }
            }
        }
    });
}