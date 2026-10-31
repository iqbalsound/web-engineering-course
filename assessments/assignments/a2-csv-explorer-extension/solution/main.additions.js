let sortKey = null, sortDir = 1, filterText = '';
const val = v => (v !== '' && !isNaN(v) ? Number(v) : String(v).toLowerCase());
const view = () => {
  let list = students.filter(s => (s.name + ' ' + s.email).toLowerCase().includes(filterText));
  if (sortKey) list = list.toSorted((a, b) => (val(a[sortKey]) > val(b[sortKey]) ? 1 : val(a[sortKey]) < val(b[sortKey]) ? -1 : 0) * sortDir);
  return list;
};
// in render(): iterate view(), set data-id on the editable cell, then
document.querySelector('#bad').textContent = students.filter(s => !EMAIL.test(s.email)).length + ' invalid e-mail(s)';

document.querySelector('#t thead').addEventListener('click', e => {
  const th = e.target.closest('th[data-key]'); if (!th) return;
  sortDir = sortKey === th.dataset.key ? -sortDir : 1; sortKey = th.dataset.key; render();
});
document.querySelector('#filter').addEventListener('input', e => { filterText = e.target.value.trim().toLowerCase(); render(); });
// editing: const s = students.find(x => String(x.id) === td.dataset.id);

let text;
try {
  const res = await fetch(base + 'students.csv', { signal: AbortSignal.timeout(5000) });
  if (!res.ok) throw new Error('HTTP ' + res.status);
  text = await res.text();
} catch (err) {
  document.querySelector('#msg').textContent = 'Could not load students.csv (' + err.name + ').';
  text = 'id,name,email,marks';
}
