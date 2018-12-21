import Request from '../core/Request';

class RoleRequest extends Request{
    retrieve() {
        return this.get('/api/roles');
    }

    create() {
        return this.get('/api/roles/create');
    }

    store() {
        return this.post('/api/role');
    }

    edit() {
        return this.get('/api/roles/edit');
    }

    update(role) {
        return this.patch(`/api/role/${role}`);
    }

    updateRolePermission() {
        return this.patch('/api/role-permission');
    }

    destroy(role) {
        return this.delete(`/api/role/${role}`);
    }
}

export default RoleRequest
