export default class NoteService
{
    async getNotes() {
        const response = await fetch('/notes', { credentials: "same-origin" })
        const data = await response.json();

        return data;
    } 
}
