import Request from '../core/Request';

class RecordTeamsRequest extends Request{
    retrieve(recordType, record) {
        return this.get(`/api/records/${recordType}/${record}/teams`);
    }

    store(recordType, record, team) {
        return this.post(`/api/records/${recordType}/${record}/teams/${team}`);
    }

    destroy(recordType, record, team) {
        return this.delete(`/api/records/${recordType}/${record}/teams/${team}`);
    }
}

export default RecordTeamsRequest
