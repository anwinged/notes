import Note from '../models/Note.js';

export default class NoteService {
    /**
     * @type {Number}
     */
    static draftId = 1;

    /**
     * @returns {Promise.<Note>}
     */
    async getNotes() {
        const response = await fetch('/notes', {
            credentials: 'same-origin',
        });

        if (response.status === 200) {
            const data = await response.json();
            return data.map(obj => {
                return Object.assign(new Note(), obj);
            });
        }

        if (response.status === 404) {
            return [];
        }

        throw new Error(
            `Unexpected answer ${response.status} ${response.statusText}`
        );
    }

    /**
     * @param {Number} id
     * @returns {Promise.<Note>}
     */
    async getNote(id) {
        const response = await fetch(`/notes/${id}`, {
            credentials: 'same-origin',
        });

        if (response.status === 200) {
            return Object.assign(new Note(), await response.json());
        }

        if (response.status === 404) {
            return null;
        }

        throw new Error(
            `Unexpected answer ${response.status} ${response.statusText}`
        );
    }

    /**
     * @returns {Promise.<Note>}
     */
    async create({ source }) {
        const response = await fetch('/notes/', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-type': 'application/json; charset=UTF-8',
            },
            body: JSON.stringify({ source }),
        });

        return Object.assign(new Note(), await response.json());
    }

    /**
     * @returns {Promise.<Note>}
     */
    async update({ id, source }) {
        const response = await fetch(`/notes/${id}`, {
            method: 'PUT',
            credentials: 'same-origin',
            headers: {
                'Content-type':
                    'application/x-www-form-urlencoded; charset=UTF-8',
            },
            body: JSON.stringify({ source }),
        });

        return Object.assign(new Note(), await response.json());
    }

    /**
     * @returns {Note}
     */
    createDraft() {
        const note = new Note();
        note.draft = true;
        note.id = `draft_${this.constructor.draftId}`;
        this.constructor.draftId += 1;
        return note;
    }
}
