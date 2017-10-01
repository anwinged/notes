import EntityState from './entity-state.js';
import BaseEntity from './base-entity.js';

export default class Note extends BaseEntity {
    /**
     * @type {Number}
     */
    id;

    /**
     * @type {String}
     */
    source;

    /**
     * @type {String}
     */
    title;

    /**
     * @type {String}
     */
    short;

    /**
     * @type {String}
     */
    html;

    /**
     * @type {Number}
     */
    createdAt;

    /**
     * @type {Number}
     */
    updatedAt;

    /**
     * @type {Boolean}
     */
    archived;

    /**
     * @return {{
     *  full: boolean,
     *  preview: boolean,
     *  draft: boolean,
     *  finished: boolean,
     *  archived: Boolean,
     *  active: boolean
     * }}
     */
    get is() {
        const state = this._meta.state;
        return {
            full: state === EntityState.DRAFT || state === EntityState.FULL,
            preview: state === EntityState.PREVIEW,
            draft: state === EntityState.DRAFT,
            finished: state !== EntityState.DRAFT,
            archived: this.archived,
            active: !this.archived,
        };
    }
}
