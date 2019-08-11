export default class EntityGate {
    /**
     * @type {Http}
     */
    http;

    /**
     * @type {RequestFactory}
     */
    requestFactory;

    /**
     * @type {EntityFactory}
     */
    entityFactory;

    constructor(http, requestFactory, entityFactory) {
        this.http = http;
        this.requestFactory = requestFactory;
        this.entityFactory = entityFactory;
    }

    /**
     * @param {object} options
     * @return {Promise.<Response>}
     */
    async execute(options) {
        const request = this.requestFactory.create(options);
        return this.http.execute(request);
    }

    /**
     * @param {Response} response
     * @param {String} name
     * @return {Promise.<Object>}
     */
    async fetchObject(response, name) {
        const data = await response.json();
        return this.entityFactory.entity(data, name);
    }

    /**
     * @param {Response} response
     * @param {String} name
     * @return {Promise.<Object[]>}
     */
    async fetchList(response, name) {
        const data = await response.json();
        return this.entityFactory.collection(data, name);
    }

    /**
     * @param response
     */
    error(response) {
        throw new Error(
            `Unexpected answer ${response.status} ${response.statusText}`
        );
    }
}
