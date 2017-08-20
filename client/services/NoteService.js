export default class NoteService
{
    async getNotes() {
        const response = await fetch('/notes', { credentials: "same-origin" });
        const data = await response.json();

        return data;
    }

    async getNote(id) {
        const response = await fetch('/notes/' + id, { credentials: "same-origin" });
        const data = await response.json();

        return data;
    }

    async create(text) {
        const response = await fetch('/notes/', {
            method: 'post',
            credentials: 'same-origin',
            headers: {
                'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'
            },
            body: 'source='+encodeURI(text),
        });
    }
}
