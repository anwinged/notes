export default class Http {
    /**
     * @type {Logger}
     */
    logger;

    constructor(logger) {
        this.logger = logger;
    }
    /**
     * @param request
     * @return {Promise.<Response>}
     */
    async execute(request) {
        this.logger.log('REQUEST', request);
        return fetch(request.path, this._prepare(request));
    }

    /**
     * @param {Request} request
     * @return {object}
     */
    _prepare(request) {
        const options = {
            method: request.method,
            headers: request.headers,
            credentials: 'same-origin',
        };

        if (request.body !== null) {
            options.body = JSON.stringify(request.body);
            options.headers['Content-type'] = 'application/json; charset=UTF-8';
        }

        return options;
    }
}
