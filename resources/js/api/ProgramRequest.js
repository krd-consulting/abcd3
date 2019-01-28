import Request from '../core/Request';

class ProgramRequest extends Request{
    retrieve() {
        return this.get('/api/programs');
    }

    show(id) {
        return this.get('/api/programs/' + id);
    }

    store() {

    }
}

export default ProgramRequest
