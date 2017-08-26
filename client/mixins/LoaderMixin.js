import Loader from '../components/Loader.vue';
import NotFound from '../components/NotFound.vue';

export default {
    components: {
        'loader': Loader,
        'not-found': NotFound,
    },
    computed: {
        loadingItem() {
            return { id: 'id' }
        },
        loading() {
            return this.loadingItem === 'loading';
        },
        found() {
            return this.loadingItem !== null && this.loadingItem.id;
        },
        missed() {
            return this.loadingItem === null;
        }
    },
}
