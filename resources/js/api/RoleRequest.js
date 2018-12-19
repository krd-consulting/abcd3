import Request from '../core/Request';

class RoleRequest extends Request{
    retrieve() {
        return this.get('/api/roles');
    }

    create() {
        return this.get('/api/roles/create');
    }

    update() {
        return this.patch('/api/role-permission');
    }
}

export default RoleRequest
