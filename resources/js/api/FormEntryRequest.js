import Request from '../core/Request';

class FormEntry extends Request {
    store(form) {
    	return this.post(`/api/forms/${form}`);
    }
}

export default FormEntry