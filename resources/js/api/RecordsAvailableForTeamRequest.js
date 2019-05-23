import Request from '../core/Request';

class RecordsAvailableForTeamRequest extends Request{
    retrieve(team, recordType) {
        return this.get(`/api/teams/${team}/available-records/${recordType}`);
    }
}

export default RecordsAvailableForTeamRequest
