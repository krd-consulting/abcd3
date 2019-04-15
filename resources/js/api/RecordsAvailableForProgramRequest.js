import Request from '../core/Request';

class RecordsAvailableForProgramRequest extends Request{
    retrieve(program, recordType) {
        return this.get(`/api/programs/${program}/available-records/${recordType}`);
    }
}

export default RecordsAvailableForProgramRequest
