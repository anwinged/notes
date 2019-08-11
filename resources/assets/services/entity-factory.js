export default class EntityFactory {
    /**
     * @type {object}
     */
    container;

    /**
     * @param {object} container
     */
    constructor(container) {
        this.container = container;
    }

    /**
     * @param {object} responseData
     * @param {string} name
     * @return {object}
     */
    entity(responseData, name) {
        const value = responseData.data || {};
        const meta = responseData.meta || {};
        return this._create(name, value, meta);
    }

    /**
     * @param {Array} responseData
     * @param {string} name
     * @return {Array}
     */
    collection(responseData, name) {
        const values = responseData.data || [];
        const meta = responseData.meta || {};
        return values.map(i => this._create(name, i, meta));
    }

    /**
     * @param {object} data
     * @param {string} name
     * @param {object} meta
     * @return {object}
     * @private
     */
    _create(name, data, meta) {
        const factory = this.container.Entity[name];
        const instance = factory.instance();
        return Object.assign(instance, data, { _meta: meta });
    }
}
