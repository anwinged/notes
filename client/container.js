import Bottle from 'bottlejs';
import EntityFactory from './services/entity-factory.js';
import Http from './services/http/http.js';
import Logger from './services/logger.js';
import NoteService from './services/note-service.js';
import UserService from './services/user-service.js';
import RequestFactory from './services/http/request-factory.js';

// Entities
import UserEntity from './entity/User.js';
import NoteEntity from './entity/Note.js';

// Container configuration

Bottle.config.strict = true;
const bottle = new Bottle();

// Service declaration

bottle.service('Logger', Logger);
bottle.service('Http', Http, 'Logger');
bottle.service('RequestFactory', RequestFactory);
bottle.factory('EntityFactory', container => {
    return new EntityFactory(container);
});
bottle.service(
    'NoteService',
    NoteService,
    'Http',
    'RequestFactory',
    'EntityFactory'
);
bottle.service(
    'UserService',
    UserService,
    'Http',
    'RequestFactory',
    'EntityFactory'
);

bottle.instanceFactory('Entity.User', () => new UserEntity());
bottle.instanceFactory('Entity.Note', () => new NoteEntity());

// Container export

const container = bottle.container;
export default container;
