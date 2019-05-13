import Request from '../core/Request';

class ProgramRecordsRequest extends Request{
    retrieve(program, recordType) {
        return this.get(`/api/programs/${program}/records/${recordType}`);
    }

    store(program, recordType, record) {
        return this.post(`/api/programs/${program}/records/${recordType}/${record}`);
    }

    edit(program, recordType, record) {
        return this.get(`/api/programs/${program}/records/${recordType}/${record}/edit`);
    }

    update(program, recordType, record) {
        return this.patch(`/api/programs/${program}/records/${recordType}/${record}`);
    }

    destroy(program, recordType, record) {
        return this.delete(`/api/programs/${program}/records/${recordType}/${record}`);
    }
}

export default ProgramRecordsRequest
