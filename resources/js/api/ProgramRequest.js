import Request from '../core/Request';

class ProgramRequest extends Request{
    retrieve() {
        return this.get('/api/programs');
    }

    show(id) {
        return this.get('/api/programs/' + id);
    }

    create() {
        return this.get('/api/programs/create');
    }

    edit(program) {
        return this.get(`/api/programs/${program}/edit`);
    }

    store() {
        return this.post('/api/programs');
    }

    update(program) {
        return this.put(`/api/programs/${program}`);
    }

    destroy(id) {
        return this.delete('/api/programs/' + id);
    }
}

export default ProgramRequest
