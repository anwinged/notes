import Bottle from 'bottlejs';
import EntityFactory from './services/entity-factory.js';
import EntityGate from './services/entity-gate.js';
import Http from './services/http/http.js';
import Logger from './services/logger.js';
import NoteService from './services/note-service.js';
import RequestFactory from './services/http/request-factory.js';

// Entities
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
    'EntityGate',
    EntityGate,
    'Http',
    'RequestFactory',
    'EntityFactory'
);
bottle.service('NoteService', NoteService, 'EntityGate');

// Entities

bottle.instanceFactory('Entity.Note', () => new NoteEntity());

// Container export

const container = bottle.container;
export default container;
