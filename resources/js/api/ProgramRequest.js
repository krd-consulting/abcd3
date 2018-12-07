import Request from '../core/Request';

class ProgramRequest extends Request{
    retrieve(id) {
        return this.get('/api/programs/' + id);
    }

    store() {

    }
}

export default ProgramRequest
