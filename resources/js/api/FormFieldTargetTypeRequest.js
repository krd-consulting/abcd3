import Request from '../core/Request';

class FormFieldTargetType extends Request {
    retrieve() {
        return this.get(`/api/forms/fields/target_types`);
    }

    show(target_type) {
    	return this.get(`/api/forms/fields/target_types/${target_type}`);
    }
}

export default FormFieldTargetType