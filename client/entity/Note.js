import NoteState from './NoteState.js';

export default class Note {
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
     * @type {{state: string}}
     */
    _meta = {
        state: NoteState.EMPTY,
    };

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
            full: state === NoteState.DRAFT || state === NoteState.FULL,
            preview: state === NoteState.PREVIEW,
            draft: state === NoteState.DRAFT,
            finished: state !== NoteState.DRAFT,
            archived: this.archived,
            active: !this.archived,
        };
    }

    /**
     *
     * @return {{state: string}}
     */
    get meta() {
        return this._meta;
    }

    /**
     * @return {string}
     */
    get state() {
        return this._meta.state || '';
    }
}
