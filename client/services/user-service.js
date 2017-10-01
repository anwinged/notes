const ENTITY_NAME = 'User';

export default class UserService {
    /**
     * @type {EntityGate}
     * @private
     */
    gate;

    constructor(gate) {
        this.gate = gate;
    }

    /**
     * @returns {Promise.<User>}
     */
    async getProfile() {
        const response = await this.gate.execute({
            path: `/profile/`,
        });

        if (response.status === 200) {
            return this.gate.fetchObject(response, ENTITY_NAME);
        }

        this.gate.error(response);
    }
}
