import Note from '../entity/Note.js';
import EntityState from '../entity/entity-state.js';

const ENTITY_NAME = 'Note';

export default class NoteService {
    /**
     * @type {Number}
     * @private
     */
    static draftId = 1;

    /**
     * @type {EntityGate}
     * @private
     */
    gate;

    constructor(gate) {
        this.gate = gate;
    }

    /**
     * @returns {Promise.<Note[]>}
     */
    async getNotes() {
        const response = await this.gate.execute({
            path: '/notes/',
        });

        if (response.status === 200) {
            return this.gate.fetchList(response, ENTITY_NAME);
        }

        if (response.status === 404) {
            return [];
        }

        this.gate.error(response);
    }

    /**
     * @param {Number} id
     * @returns {Promise.<Note>}
     */
    async getNote(id) {
        const response = await this.gate.execute({
            path: `/notes/${id}`,
        });

        if (response.status === 200) {
            return this.gate.fetchObject(response, ENTITY_NAME);
        }

        if (response.status === 404) {
            return null;
        }

        this.gate.error(response);
    }

    /**
     * @returns {Promise.<Note>}
     */
    async create({ source }) {
        const response = await this.gate.execute({
            method: 'post',
            path: '/notes/',
            body: { source },
        });

        if (response.status === 201) {
            return this.gate.fetchObject(response, ENTITY_NAME);
        }

        this.gate.error(response);
    }

    /**
     * @returns {Promise.<Note>}
     */
    async update({ id, source }) {
        const response = await this.gate.execute({
            method: 'put',
            path: `/notes/${id}`,
            body: { source },
        });

        if (response.status === 200) {
            return this.gate.fetchObject(response, ENTITY_NAME);
        }

        this.gate.error(response);
    }

    /**
     * @param id
     * @return {Promise.<void>}
     */
    async archive({ id }) {
        const response = await this.gate.execute({
            method: 'post',
            path: `/notes/${id}/archive`,
        });

        if (response.status === 200) {
            return this.gate.fetchObject(response, ENTITY_NAME);
        }

        this.gate.error(response);
    }

    /**
     * @param id
     * @return {Promise.<void>}
     */
    async restore({ id }) {
        const response = await this.gate.execute({
            method: 'post',
            path: `/notes/${id}/restore`,
        });

        if (response.status === 200) {
            return this.gate.fetchObject(response, ENTITY_NAME);
        }

        this.gate.error(response);
    }

    /**
     * @param {string} text
     * @return {Promise<Object>}
     */
    async search(text) {
        const response = await this.gate.execute({
            method: 'get',
            path: `/notes/search?q=${text}`,
        });

        if (response.status === 200) {
            return this.gate.fetchList(response, ENTITY_NAME);
        }

        this.gate.error(response);
    }

    /**
     * @returns {Note}
     */
    createDraft() {
        const note = new Note();
        note._meta.state = EntityState.DRAFT;
        note.id = `draft_${this.constructor.draftId}`;
        this.constructor.draftId += 1;
        return note;
    }

    /**
     * @returns {Note}
     */
    createLoading() {
        const note = new Note();
        note._meta.state = EntityState.PREVIEW;
        return note;
    }

    /**
     * @returns {Note}
     */
    createMissing() {
        const note = new Note();
        note._meta.state = EntityState.MISSING;
        return note;
    }
}
