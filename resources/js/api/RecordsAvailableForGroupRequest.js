import Request from '../core/Request';

class RecordsAvailableForGroupRequest extends Request{
    retrieve(group, recordType) {
        return this.get(`/api/groups/${group}/available-records/${recordType}`);
    }
}

export default RecordsAvailableForGroupRequest
