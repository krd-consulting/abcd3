import Request from '../core/Request';

class FormEntry extends Request {
    retrieve(form) {
        return this.get(`/api/forms/${form}/entries`);
    }

    teams(form) {
      return this.get(`/api/forms/${form}/entries/teams`);
    }

    store(form) {
    	return this.post(`/api/forms/${form}`);
    }
}

export default FormEntry
