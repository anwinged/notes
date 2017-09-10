export default class Request {
    /**
     * @type {string}
     * @private
     */
    _method = 'get';

    /**
     * @type {string}
     * @private
     */
    _path = '';

    /**
     * @type {object}
     * @private
     */
    _headers = {};

    /**
     * @type {object|string|null}
     * @private
     */
    _body = null;

    constructor(options) {
        for (const key of Object.keys(options)) {
            const okey = '_' + key;
            if (this.hasOwnProperty(okey)) {
                this[okey] = options[key];
            }
        }
    }

    /**
     * Returns http method.
     * @return {string}
     */
    get method() {
        return this._method;
    }

    /**
     * Returns http path;
     * @return {string}
     */
    get path() {
        return this._path;
    }

    /**
     * Returns extra headers.
     * @return {object}
     */
    get headers() {
        return this._headers;
    }

    /**
     * Returns request body.
     * @return {null|object}
     */
    get body() {
        return this._body;
    }
}
