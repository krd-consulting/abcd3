import Request from '../core/Request';

class RoleRequest extends Request{
    retrieve(id) {
        return this.get('/api/roles/' + id);
    }
}

export default RoleRequest
