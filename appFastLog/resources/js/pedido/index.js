import PedidoService from './PedidoService';
import { initDataTable } from './datatables';
import { initEvents } from './functions';

const service = new PedidoService();

initDataTable();
initEvents(service);