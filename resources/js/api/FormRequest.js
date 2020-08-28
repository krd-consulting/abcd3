import Request from '../core/Request';

class Form extends Request {
    retrieve() {
        return this.get(`/api/forms`);
    }

    retrieve() {
      return this.get(`/api/forms`);
    }


    show(form) {
        return this.get(`/api/forms/${form}`);
    }

    fieldDataF(form, field) {
      return this.get(`/api/forms/${form}/field-data/${field}`);
    }

    create() {
        return this.get(`/api/forms/create`);
    }

    validate() {
        return this.post(`/api/forms/create`);
    }

    store() {
    	return this.post(`/api/forms`);
    }

    edit(form) {
    	return this.get(`/api/forms/${form}/edit`);
    }

    update(form) {
    	return this.patch(`/api/forms/${form}`);
    }

    destroy(form) {
    	return this.delete(`/api/forms/${form}`);
    }
}

export default Form
