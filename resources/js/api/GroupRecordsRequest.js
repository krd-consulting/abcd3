import Request from '../core/Request';

class GroupRecordsRequest extends Request{
    retrieve(group, recordType) {
        return this.get(`/api/groups/${group}/records/${recordType}`);
    }

    store(group, recordType, record) {
        return this.post(`/api/groups/${group}/records/${recordType}/${record}`);
    }

    // edit(program, recordType, record) {
    //     return this.get(`/api/programs/edit/${program}/records/${recordType}/${record}`);
    // }

    // update(program, recordType, record) {
    //     return this.patch(`/api/programs/${program}/records/${recordType}/${record}`);
    // }

    // destroy(program, recordType, record) {
    //     console.log(`/api/programs/${program}/records/${recordType}/${record}`);

    //     return this.delete(`/api/programs/${program}/records/${recordType}/${record}`);
    // }
}

export default GroupRecordsRequest
