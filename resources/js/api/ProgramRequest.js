import Request from '../core/Request';

class ProgramRequest extends Request{
    view(id) {
        return this.get('/api/programs/' + id);
    }

    store() {

    }
}

export default ProgramRequest
