import Request from '../core/Request';

class Form extends Request{
    retrieve() {
        return this.get(`/api/forms`);
    }

    create() {
        return this.get(`/api/forms/create`);
    }

    validate() {
        return this.post(`/api/forms/create`);
    }

    // store() {
    // 	return this.post(`/api/programs/client-statuses`);
    // }

    // edit(status) {
    // 	return this.get(`/api/programs/client-statuses/${status}/edit`);
    // }

    // update(status) {
    // 	return this.patch(`/api/programs/client-statuses/${status}`);
    // }

    // destroy(status) {
    // 	return this.delete(`/api/programs/client-statuses/${status}`);
    // }
}

export default Form
