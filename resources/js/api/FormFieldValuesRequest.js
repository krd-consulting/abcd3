import Request from '../core/Request';

class FormFieldValues extends Request {
    retrieve(field) {
        return this.get(`/api/form-fields/${field}/values`);
    }
}

export default FormFieldValues
