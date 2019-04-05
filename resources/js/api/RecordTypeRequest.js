import Request from '../core/Request';

class RecordType extends Request{
    retrieve() {
        return this.get(`/api/record-types`);
    }
}

export default RecordType
