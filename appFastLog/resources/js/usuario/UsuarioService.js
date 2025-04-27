export default class UsuarioService {
    constructor(baseURL = '/usuario') {
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

    async deletar(id) {
        console.log(`${this.baseURL}/${id}`);
        return axios.delete(`${this.baseURL}/${id}`);
        
    }

    async buscar(id) {
        return axios.get(`${this.baseURL}/${id}`);
    }
}
