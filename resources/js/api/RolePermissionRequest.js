import Request from '../core/Request';

class RolePermissionRequest extends Request{
    store(role, permission) {
        return this.post(`/api/role/${role}/permission/${permission}`);
    }

    destroy(role, permission) {
        return this.delete(`/api/role/${role}/permission/${permission}`);
    }
}

export default RolePermissionRequest
