async function showSeatsLeft(list) {
  const response = await fetch(list.dataset.seatsUrl);
  if (!response.ok) {
    return;
  }

  const seats = await response.json();
  for (const conference of seats) {
    const element = list.querySelector(
      `[data-conference="${conference.uid}"] [data-seats]`,
    );
    if (element) {
      element.querySelector('[data-seats-count]').textContent =
        conference.seatsLeft;
      element.hidden = false;
    }
  }
}

const list = document.querySelector('[data-seats-url]');
if (list) {
  showSeatsLeft(list);
}
