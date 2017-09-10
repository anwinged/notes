import Vue from 'vue';
import Vuex from 'vuex';
import logger from 'vuex/dist/logger';
import container from '../container.js';

Vue.use(Vuex);

const SET_NOTES = 'set_notes';
const ADD_NOTE = 'add_note';
const REPLACE_NOTE = 'replace_note';

/** @var NoteService {NoteService} */
const NoteService = container.NoteService;

const store = new Vuex.Store({
    plugins: [logger()],
    state: {
        user: {
            username: window.AppData.username,
        },
        notes: [],
    },
    mutations: {
        [SET_NOTES](state, notes) {
            state.notes = state.notes.concat(notes);
        },
        [ADD_NOTE](state, note) {
            state.notes.push(note);
        },
        [REPLACE_NOTE](state, { id, note }) {
            const index = state.notes.findIndex(n => n.id === id);
            if (index < 0) {
                state.notes.push(note);
            } else {
                state.notes.splice(index, 1, note);
            }
        },
    },
    getters: {
        newest(state) {
            return state.notes.slice().sort((a, b) => {
                if (a.draft || b.draft) {
                    return 1;
                }
                return b.updatedAt - a.updatedAt;
            });
        },
    },
    actions: {
        async loadStartNotes({ commit }) {
            const notes = await NoteService.getNotes();
            commit(SET_NOTES, notes);
        },
        async getNote({ state }, id) {
            const founded = state.notes.find(note => note.id === id);
            if (founded !== undefined) {
                return founded;
            }
            return NoteService.getNote(id);
        },
        async createDraftNote({ commit }) {
            const draft = NoteService.createDraft();
            commit(ADD_NOTE, draft);
            return draft;
        },
        async saveNote({ commit }, note) {
            const updated = note.draft
                ? await NoteService.create(note)
                : await NoteService.update(note);
            commit(REPLACE_NOTE, { id: note.id, note: updated });
            return updated;
        },
    },
});

export default store;
