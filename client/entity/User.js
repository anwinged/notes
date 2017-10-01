import BaseEntity from './base-entity.js';

export default class User extends BaseEntity {
    /**
     * @type {String}
     */
    username;

    /**
     * @type {String}
     */
    email;
}
