import Request from '../core/Request';

class RecordPrograms extends Request{
    retrieve(recordType, record) {
        return this.get(`/api/records/${recordType}/${record}/programs`);
    }
}

export default RecordPrograms
