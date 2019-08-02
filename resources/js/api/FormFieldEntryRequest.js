import Request from '../core/Request';

class FormFieldEntry extends Request {
    retrieve(form, field) {
        return this.get(`/api/forms/${form}/fields/${field}/entries`);
    }
}

export default FormFieldEntry
