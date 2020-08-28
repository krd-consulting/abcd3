import Request from '../core/Request';

class FormField extends Request {
    retrieve(form) {
        return this.get(`/api/forms/${form}/fields`);
    }

    show(field) {
    	return this.get(`/api/form-fields/${field}`);
    }
}

export default FormField
