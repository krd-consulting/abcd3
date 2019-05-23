import Request from '../core/Request';

class TeamGroupsRequest extends Request{
    retrieve(team) {
        return this.get(`/api/teams/${team}/groups`);
    }

    destroy(group) {
        return this.delete(`/api/groups/${group}`);
    }
}

export default TeamGroupsRequest
