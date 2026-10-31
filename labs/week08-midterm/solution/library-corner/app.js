const q = document.querySelector('#q');
const max = document.querySelector('#max');
const cards = [...document.querySelectorAll('.card')];
const count = document.querySelector('#count');

function apply() {
  const term = q.value.trim().toLowerCase();
  const limit = max.value === '' ? Infinity : Number(max.value);
  let shown = 0;
  for (const c of cards) {
    const ok = c.querySelector('h3').textContent.toLowerCase().includes(term) && Number(c.dataset.price) <= limit;
    c.hidden = !ok;
    if (ok) shown++;
  }
  count.textContent = shown + ' book(s) shown';
}
q.addEventListener('input', apply);
max.addEventListener('input', apply);
document.querySelector('#filter').addEventListener('submit', e => e.preventDefault());
apply();
