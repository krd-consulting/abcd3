import Request from '../core/Request';

class ProgramGroupsRequest extends Request{
    retrieve(program) {
        return this.get(`/api/programs/${program}/groups`);
    }

    destroy(group) {
        return this.delete(`/api/groups/${group}`);
    }
}

export default ProgramGroupsRequest
