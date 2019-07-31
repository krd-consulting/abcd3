import Request from '../core/Request';

class FormField extends Request {
    retrieve(form) {
        return this.get(`/api/forms/${form}/fields`);
    }
}

export default FormField
