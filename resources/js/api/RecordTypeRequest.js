import Request from '../core/Request';

class RecordType extends Request{
    retrieve() {
        return this.get(`/api/record-types`);
    }

    show(recordType) {
        return this.get(`/api/record-types/${recordType}`);
    }
}

export default RecordType
