import Request from '../core/Request';

class ProgramsAvailableForRecordRequest extends Request{
    retrieve(recordType, record) {
        return this.get(`/api/records/${recordType}/${record}/available-programs`);
    }
}

export default ProgramsAvailableForRecordRequest
