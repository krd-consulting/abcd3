import Request from '../core/Request';

class FormFieldEntry extends Request {
    retrieve(field) {
        return this.get(`/api/form-fields/${field}/entries`);
    }
}

export default FormFieldEntry
