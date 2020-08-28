import Request from '../core/Request';

class CollectionRequest extends Request{
    retrieve() {
      return this.get(`/api/collections`);
    }

    show(collection) {
      return this.get(`/api/collections/${collection}`);
    }
}

export default CollectionRequest
