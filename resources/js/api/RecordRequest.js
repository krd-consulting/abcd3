import Request from '../core/Request';

class RecordRequest extends Request{
    retrieve(recordType) {
        return this.get(`/api/records/${recordType}`);
    }

    show(recordType, record) {
        return this.get(`/api/records/${recordType}/${record}`);
    }

    create(recordType) {
        return this.get(`/api/records/${recordType}/create`);
    }

    store(recordType) {
        return this.post(`/api/records/${recordType}`);
    }

    edit(recordType, record) {
        return this.get(`/api/records/${recordType}/${record}/edit`);
    }

    update(recordType, record) {
        return this.patch(`/api/records/${recordType}/${record}`);
    }

    destroy(record) {
        return this.delete(`/api/records/${record}`);
    }
}

export default RecordRequest
