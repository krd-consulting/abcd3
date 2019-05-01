import Request from '../core/Request';

class GroupRecordsRequest extends Request{
    retrieve(group, recordType) {
        return this.get(`/api/groups/${group}/records/${recordType}`);
    }

    store(group, recordType, record) {
        return this.post(`/api/groups/${group}/records/${recordType}/${record}`);
    }

    destroy(group, recordType, record) {
        return this.delete(`/api/groups/${group}/records/${recordType}/${record}`);
    }
}

export default GroupRecordsRequest
