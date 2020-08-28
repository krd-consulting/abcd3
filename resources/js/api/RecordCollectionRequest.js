import Request from '../core/Request';

class RecordCollectionRequest extends Request{
    retrieve(recordType, record, collection) {
      return this.get(`/api/records/${recordType}/${record}/collections/${collection}`);
    }

    store(recordType, record, collection, item) {
      return this.post(`/api/records/${recordType}/${record}/collections/${collection}/${item}`);
    }

    available(recordType, record, collection) {
      return this.get(`/api/records/${recordType}/${record}/collections/${collection}/available`);
    }
}

export default RecordCollectionRequest
