export default class NoteService
{
    async getNotes() {
        const response = await fetch('/notes', {
            credentials: 'same-origin'
        });
        return response.json();
    }

    async getNote(id) {
        const response = await fetch(`/notes/${id}`, {
            credentials: 'same-origin'
        });
        return response.json();
    }

    async create(text) {
        const response = await fetch('/notes/', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'
            },
            body: 'source=' + encodeURI(text),
        });
    }

    async update(id, text) {
        const response = await fetch(`/notes/${id}`, {
            method: 'PUT',
            credentials: 'same-origin',
            headers: {
                'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'
            },
            body: 'source=' + encodeURI(text),
        });
    }
}
