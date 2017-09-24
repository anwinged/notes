import Note from '../entity/Note.js';
import NoteState from '../entity/NoteState';

export default class NoteService {
    /**
     * @type {Number}
     */
    static draftId = 1;

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
        return this.entityFactory.entity(data, 'Note');
    }

    /**
     * @param {Response} response
     * @return {Promise.<Object[]>}
     * @private
     */
    async _fetchList(response) {
        const data = await response.json();
        return this.entityFactory.collection(data, 'Note');
    }

    _error(response) {
        throw new Error(
            `Unexpected answer ${response.status} ${response.statusText}`
        );
    }

    /**
     * @returns {Promise.<Note[]>}
     */
    async getNotes() {
        const response = await this._execute({
            path: '/notes/',
        });

        if (response.status === 200) {
            return this._fetchList(response, 'Note');
        }

        if (response.status === 404) {
            return [];
        }

        this._error(response);
    }

    /**
     * @param {Number} id
     * @returns {Promise.<Note>}
     */
    async getNote(id) {
        const response = await this._execute({
            path: `/notes/${id}`,
        });

        if (response.status === 200) {
            return this._fetchObject(response, 'Note');
        }

        if (response.status === 404) {
            return null;
        }

        this._error(response);
    }

    /**
     * @returns {Promise.<Note>}
     */
    async create({ source }) {
        const response = await this._execute({
            method: 'post',
            path: '/notes/',
            body: { source },
        });

        if (response.status === 201) {
            return this._fetchObject(response, 'Note');
        }

        this._error(response);
    }

    /**
     * @returns {Promise.<Note>}
     */
    async update({ id, source }) {
        const response = await this._execute({
            method: 'put',
            path: `/notes/${id}`,
            body: { source },
        });

        if (response.status === 200) {
            return this._fetchObject(response, 'Note');
        }

        this._error(response);
    }

    /**
     * @param id
     * @return {Promise.<void>}
     */
    async archive({ id }) {
        const response = await this._execute({
            method: 'post',
            path: `/notes/${id}/archive`,
        });

        if (response.status === 200) {
            return this._fetchObject(response, 'Note');
        }

        this._error(response);
    }

    /**
     * @param id
     * @return {Promise.<void>}
     */
    async restore({ id }) {
        const response = await this._execute({
            method: 'post',
            path: `/notes/${id}/restore`,
        });

        if (response.status === 200) {
            return this._fetchObject(response, 'Note');
        }

        this._error(response);
    }

    /**
     * @returns {Note}
     */
    createDraft() {
        const note = new Note();
        note._meta.state = NoteState.DRAFT;
        note.id = `draft_${this.constructor.draftId}`;
        this.constructor.draftId += 1;
        return note;
    }

    /**
     * @returns {Note}
     */
    createLoading() {
        const note = new Note();
        note._meta.state = NoteState.PREVIEW;
        return note;
    }

    /**
     * @returns {Note}
     */
    createMissing() {
        const note = new Note();
        note._meta.state = NoteState.MISSING;
        return note;
    }
}
