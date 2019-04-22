import Request from '../core/Request';

class RecordGroupsRequest extends Request{
    retrieve(recordType, record) {
        return this.get(`/api/records/${recordType}/${record}/groups`);
    }

    store(recordType, record, group) {
        return this.post(`/api/records/${recordType}/${record}/groups/${group}`);
    }

    destroy(recordType, record, group) {
        return this.delete(`/api/records/${recordType}/${record}/groups/${group}`);
    }
}

export default RecordGroupsRequest
