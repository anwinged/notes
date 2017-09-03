export default class Note
{
    id;
    source;
    html;
    createdAt;
    updatedAt;

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
}
