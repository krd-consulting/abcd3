import Request from '../core/Request';

class TeamRecordsRequest extends Request{
    retrieve(team, recordType) {
        return this.get(`/api/teams/${team}/records/${recordType}`);
    }

    store(team, recordType, record) {
        return this.post(`/api/teams/${team}/records/${recordType}/${record}`);
    }

    destroy(team, recordType, record) {
        return this.delete(`/api/teams/${team}/records/${recordType}/${record}`);
    }
}

export default TeamRecordsRequest
