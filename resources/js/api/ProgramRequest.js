import Request from '../core/Request';

class ProgramRequest extends Request{
    retrieve() {
        return this.get('/api/programs');
    }

    view(id) {
        return this.get('/api/programs/' + id);
    }

    store() {

    }
}

export default ProgramRequest
