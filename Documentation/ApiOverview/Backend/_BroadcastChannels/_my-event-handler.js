class MyEventHandler {
  constructor() {
    document.addEventListener('typo3:my_component:my_event', (e) => eventHandler(e.detail));
  }

  function eventHandler(detail) {
    console.log(detail); // contains 'hello' and 'foo' as sent in the payload
  }
}
export default new MyEventHandler();
