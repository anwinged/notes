export default class UserService {
    constructor(http, requestFactory, entityFactory) {
        this.http = http;
        this.requestFactory = requestFactory;
        this.entityFactory = entityFactory;
    }

    /**
     * @param {object} options
     * @return {Promise.<Response>}
     * @private
     */
    async _execute(options) {
        const request = this.requestFactory.create(options);
        return this.http.execute(request);
    }

    /**
     * @param {Response} response
     * @return {Promise.<Object>}
     * @private
     */
    async _fetchObject(response) {
        const data = await response.json();
        return this.entityFactory.entity(data, 'User');
    }

    _error(response) {
        throw new Error(
            `Unexpected answer ${response.status} ${response.statusText}`
        );
    }

    /**
     * @returns {Promise.<User>}
     */
    async getProfile() {
        const response = await this._execute({
            path: `/profile/`,
        });

        if (response.status === 200) {
            return this._fetchObject(response);
        }

        this._error(response);
    }
}
