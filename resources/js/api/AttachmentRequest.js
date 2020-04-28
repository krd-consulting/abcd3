import Request from '../core/Request';

class AttachmentRequest extends Request{
    show(attachment) {
        return this.get(`/api/attachments/${attachment}`);
    }

    download(attachment) {
        return this.get(`/api/downloads/attachments/${attachment}`);
    }

    destroy(attachment) {
        return this.delete(`/api/attachments/${attachment}`);
    }
}

export default AttachmentRequest
