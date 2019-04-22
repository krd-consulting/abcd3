import Request from '../core/Request';

class GroupsAvailableForRecordRequest extends Request{
    retrieve(recordType, record) {
        return this.get(`/api/records/${recordType}/${record}/available-groups`);
    }
}

export default GroupsAvailableForRecordRequest
