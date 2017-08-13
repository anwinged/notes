export default class NoteService
{
    async getNotes() {
        const response = await fetch('/notes', { credentials: "same-origin" })
        const data = await response.json();

        return data;
    }

    async getNote(id) {
        const response = await fetch('/notes/' + id, { credentials: "same-origin" })
        const data = await response.json();

        return data;
    } 
}
