import Request from '../core/Request';

class RolePermissionRequest extends Request{
    store(role, permission) {
        return this.post(`/api/roles/${role}/permissions/${permission}`);
    }

    destroy(role, permission) {
        return this.delete(`/api/roles/${role}/permissions/${permission}`);
    }
}

export default RolePermissionRequest
