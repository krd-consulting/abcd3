import Request from '../core/Request';

class AttachmentRequest extends Request{
    destroy(attachment) {
        return this.delete(`/api/attachments/${attachment}`);
    }
}

export default AttachmentRequest
