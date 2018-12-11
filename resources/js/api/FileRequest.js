import Request from '../core/Request';

class FileRequest extends Request{
    retrieve(fileType) {
        return this.get(`/api/files/${fileType}`);
    }

    show(fileType, file) {
        return this.get(`/api/files/${fileType}/${file}`);
    }

    create() {
        return this.get('/api/files/create');
    }

    store() {
        return this.post('/api/files');
    }
}

export default FileRequest
