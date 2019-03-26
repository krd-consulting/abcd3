import Request from '../core/Request';

class RecordRequest extends Request{
    retrieve(recordType) {
        return this.get(`/api/records/${recordType}`);
    }

    show(recordType, record) {
        return this.get(`/api/records/${recordType}/${record}`);
    }

    create() {
        return this.get('/api/records/create');
    }

    store() {
        return this.post('/api/records');
    }

    edit(record) {
        return this.get(`/api/records/edit/${record}`);
    }

    update(record) {
        return this.patch(`/api/records/${record}`);
    }

    destroy(record) {
        return this.delete(`/api/records/${record}`);
    }
}

export default RecordRequest
