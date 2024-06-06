import Request from '../core/Request';

class FormFieldTargetType extends Request {
    retrieve() {
        return this.get(`/api/forms/fields/target_types`);
    }

    show(target_type, target_id) {
        if(!!target_id) {
            return this.get(`/api/forms/fields/target_types/${target_type}?target_id=${target_id}`);
        }

        return this.get(`/api/forms/fields/target_types/${target_type}`);
    }
}

export default FormFieldTargetType