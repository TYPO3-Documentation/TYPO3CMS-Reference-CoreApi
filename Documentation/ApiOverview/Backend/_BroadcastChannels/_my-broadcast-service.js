import BroadcastService from "@typo3/backend/broadcast-service.js";

class MyBroadcastService {
  constructor() {
    const payload = {
      componentName: 'my_extension',
      eventName: 'my_event',
      hello: 'world',
      foo: ['bar', 'baz']
    };
    BroadcastService.post(payload);
  }
}
export default new MyBroadcastService();
