import Request from '../core/Request';

class FileRequest extends Request{
    retrieve(id) {
        return this.get('/api/files/' + id);
    }

    store() {

    }
}

export default FileRequest
