import Request from '../core/Request';

class TeamsAvailableForRecordRequest extends Request{
    retrieve(recordType, record) {
        return this.get(`/api/records/${recordType}/${record}/available-teams`);
    }
}

export default TeamsAvailableForRecordRequest
