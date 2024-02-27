import Client from '@typo3/backend/storage/client.js';

Client.set('common-prefix-a', 'a');
Client.set('common-prefix-b', 'b');
Client.set('common-prefix-c', 'c');

const entries = Client.getByPrefix('common-prefix-');
// {'common-prefix-a': 'a', 'common-prefix-b': 'b', 'common-prefix-c': 'c'}
