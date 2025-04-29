export default class EntregadorService {
    constructor(baseURL = '/entregador') {
        this.baseURL = baseURL;
    }

    async listar(params = {}) {
        return axios.get(this.baseURL, { params });
    }

    async criar(data) {
        console.log(data)
        return axios.post(this.baseURL, data);
    }

    async atualizar(id, data) {
        return axios.put(`${this.baseURL}/${id}`, data);
    }

    async deletar(id) {
        return axios.delete(`${this.baseURL}/${id}`);
    }

    async buscar(id) {
        return axios.get(`${this.baseURL}/${id}`);
    }
}