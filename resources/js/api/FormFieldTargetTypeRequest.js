import Request from '../core/Request';

class FormFieldTargetType extends Request {
    retrieve() {
        return this.get(`/api/forms/fields/target_types`);
    }
}

export default FormFieldTargetType