import Vue from 'vue';
import Vuex from 'vuex';
import logger from 'vuex/dist/logger';
import NoteService from '../services/NoteService.js';

Vue.use(Vuex);

const SET_NOTES = 'set_notes';
const ADD_NOTE = 'add_note';
const REPLACE_NOTE = 'replace_note';

const store = new Vuex.Store({
    plugins: [logger()],
    state: {
        notes: [],
    },
    mutations: {
        [SET_NOTES] (state, notes) {
            state.notes = state.notes.concat(notes);
        },
        [ADD_NOTE] (state, note) {
            state.notes.push(note);
        },
        [REPLACE_NOTE] (state, { id, note }) {
            const index = state.notes.findIndex(n => n.id === id);
            if (index < 0) {
                state.notes.push(note);
            } else {
                state.notes.splice(index, 1, note);
            }
        }
    },
    getters: {
        newest(state) {
            return state.notes.slice().sort((a, b) => {
                if (a.draft || b.draft) {
                    return 1;
                }
                return a.updatedAt > b.updatedAt ? -1 : a.updatedAt < b.updatedAt ? 1 : 0;
            });
        },
    },
    actions: {
        async loadStartNotes({ commit }) {
            const notes = await (new NoteService).getNotes();
            commit(SET_NOTES, notes);
        },
        async getNote({ state }, id) {
            const founded = state.notes.find(note => note.id === id);
            if (founded !== undefined) {
                return founded;
            }
            return (new NoteService).getNote(id);
        },
        async createDraftNote({ commit }) {
            const draft = (new NoteService).createDraft();
            commit(ADD_NOTE, draft);
            return draft;
        },
        async saveNote({ commit }, note) {
            const service = new NoteService;
            const updated = note.draft
                ? await service.create(note)
                : await service.update(note)
            ;
            commit(REPLACE_NOTE, { id: note.id, note: updated });
            return updated;
        },
    },
});

export default store;
