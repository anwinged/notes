import Request from './request.js';

export default class RequestFactory {
    /**
     * @param {object} options
     * @return {Request}
     */
    create(options) {
        return new Request(options);
    }
}
