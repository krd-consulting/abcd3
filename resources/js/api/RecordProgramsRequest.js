import Request from '../core/Request';

class RecordProgramsRequest extends Request{
    retrieve(recordType, record) {
        return this.get(`/api/records/${recordType}/${record}/programs`);
    }

    store(recordType, record, program) {
        return this.post(`/api/records/${recordType}/${record}/programs/${program}`);
    }

    destroy(recordType, record, program) {
        return this.delete(`/api/records/${recordType}/${record}/programs/${program}`);
    }
}

export default RecordProgramsRequest
