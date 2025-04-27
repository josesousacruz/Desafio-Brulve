import EntregadorService from './EntregadorService';
import { initDataTable } from './datatables';
import { initEvents } from './functions';

const service = new EntregadorService();

initDataTable();
initEvents(service);