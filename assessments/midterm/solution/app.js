const q = document.querySelector('#q');
const fee = document.querySelector('#fee');
const cards = [...document.querySelectorAll('.card')];
const count = document.querySelector('#count');
function apply() {
  const term = q.value.trim().toLowerCase();
  const max = fee.value === '' ? Infinity : Number(fee.value);
  let shown = 0;
  for (const c of cards) {
    const ok = c.querySelector('h3').textContent.toLowerCase().includes(term) && Number(c.dataset.fee) <= max;
    c.hidden = !ok;
    if (ok) shown++;
  }
  count.textContent = shown + ' event(s) shown';
}
q.addEventListener('input', apply);
fee.addEventListener('input', apply);
document.querySelector('#filter').addEventListener('submit', e => e.preventDefault());
apply();
