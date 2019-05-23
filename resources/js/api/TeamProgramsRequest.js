import Request from '../core/Request';

class TeamProgramsRequest extends Request{
    retrieve(team) {
        return this.get(`/api/teams/${team}/programs`);
    }

    destroy(program) {
        return this.delete(`/api/programs/${program}`);
    }
}

export default TeamProgramsRequest
