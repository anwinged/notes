import EntityState from './entity-state.js';

export default class BaseEntity {
    /**
     * @type {{state: string}}
     * @private
     */
    _meta = {
        state: EntityState.EMPTY,
    };

    /**
     * @return {{state: string}}
     */
    get meta() {
        return this._meta;
    }

    /**
     * @return {string}
     */
    get state() {
        return this._meta.state;
    }
}
