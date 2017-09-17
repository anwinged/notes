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
     * @type {Boolean}
     */
    draft = false;

    /**
     * @returns {Boolean}
     */
    get finished() {
        return !this.draft;
    }

    /**
     * @return {Boolean}
     */
    get active() {
        return !this.archived;
    }
}
