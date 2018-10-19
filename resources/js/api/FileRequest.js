import Request from '../core/Request';
import moment from 'moment';

class FileRequest extends Request{
    retrieve(id) {
        return this.get('/api/files/' + id);
    }

    store() {

    }
}

export default FileRequest
