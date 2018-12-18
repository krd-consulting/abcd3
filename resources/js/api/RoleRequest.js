import Request from '../core/Request';

class RoleRequest extends Request{
    retrieve() {
        return this.get('/api/roles');
    }
}

export default RoleRequest
