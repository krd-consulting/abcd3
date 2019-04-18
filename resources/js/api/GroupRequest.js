import Request from '../core/Request';

class GroupRequest extends Request{
    retrieve() {
        return this.get(`/api/groups`);
    }

    show(group) {
        return this.get(`/api/groups/${group}`);
    }

    create() {
        return this.get('/api/groups/create');
    }

    store() {
        return this.post('/api/groups');
    }

    edit(group) {
        return this.get(`/api/groups/${group}/edit`);
    }

    update(group) {
        return this.patch(`/api/groups/${group}`);
    }

    destroy(group) {
        return this.delete(`/api/groups/${group}`);
    }
}

export default GroupRequest
