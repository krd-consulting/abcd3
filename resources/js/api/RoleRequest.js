import Request from '../core/Request';

class RoleRequest extends Request{
    retrieve() {
        return this.get('/api/roles');
    }

    create() {
        return this.get('/api/roles/create');
    }

    store() {
        return this.post('/api/roles');
    }

    edit() {
        return this.get('/api/roles/edit');
    }

    update(role) {
        return this.patch(`/api/roles/${role}`);
    }

    destroy(role) {
        return this.delete(`/api/roles/${role}`);
    }
}

export default RoleRequest
