import Request from '../core/Request';

class TeamRequest extends Request{
    retrieve() {
        return this.get(`/api/teams`);
    }

    show(team) {
        return this.get(`/api/teams/${team}`);
    }

    edit(team) {
        return this.get(`/api/teams/${team}/edit`);
    }

    store() {
        return this.post('/api/teams');
    }

    update(team) {
        return this.patch(`/api/teams/${team}`);
    }

    destroy(team) {
        return this.delete(`/api/teams/${team}`);
    }
}

export default TeamRequest
