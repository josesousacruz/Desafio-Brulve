export default class PedidoService {
    constructor(baseURL = '/pedido') {
        this.baseURL = baseURL;
    }

    async listar(params = {}) {
        return axios.get(this.baseURL, { params });
    }

    async criar(data) {
        return axios.post(this.baseURL, data);
    }

    async atualizar(id, data) {
        return axios.put(`${this.baseURL}/${id}`, data);
    }

    async excluir(id) {
        return axios.delete(`${this.baseURL}/${id}`);
    }

    async buscar(id) {
        return axios.get(`${this.baseURL}/${id}`);
    }

    async atualizarStatus(id, status) {
        return axios.put(`${this.baseURL}/${id}/status`, { status });
    }
}