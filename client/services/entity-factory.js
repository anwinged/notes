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
     * @param {object} data
     * @param {string} name
     * @return {object}
     */
    entity(data, name) {
        return this._create(data, name);
    }

    /**
     * @param {Array} data
     * @param {string} name
     * @return {Array}
     */
    collection(data, name) {
        return data.map(i => this._create(i, name));
    }

    /**
     * @param {object} data
     * @param {string} name
     * @return {object}
     * @private
     */
    _create(data, name) {
        const factory = this.container.Entity[name];
        const instance = factory.instance();
        return Object.assign(instance, data);
    }
}
