import Request from '../core/Request';

class FormEntry extends Request {
    retrieve(form) {
        return this.get(`/api/forms/${form}/entries`);
    }
    
    store(form) {
    	return this.post(`/api/forms/${form}`);
    }
}

export default FormEntry