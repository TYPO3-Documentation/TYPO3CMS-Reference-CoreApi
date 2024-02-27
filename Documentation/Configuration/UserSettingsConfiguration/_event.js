document.querySelectorAll('[data-event-name]')
  .forEach((element: HTMLElement) => {
    element.addEventListener('setup:customButton:clicked', (evt: Event) => {
      alert('clicked the button');
    });
  });
document.querySelectorAll('[data-event-name]')
  .forEach((element: HTMLElement) => {
    element.addEventListener('setup:customButton:confirmed', (evt: Event) => {
      evt.detail.result && alert('confirmed the modal dialog');
    });
  });
