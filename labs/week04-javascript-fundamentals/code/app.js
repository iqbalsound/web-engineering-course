import { addExpense, totalsByCategory, grade } from './expenses.js';
let expenses = [];
const list = document.querySelector('#list'), summary = document.querySelector('#summary');
document.querySelector('#f').addEventListener('submit', e => {
  e.preventDefault();
  const d = new FormData(e.target);
  try { expenses = addExpense(expenses, { title: d.get('title'), amount: Number(d.get('amount')), category: d.get('category') }); }
  catch (err) { alert(err.message); return; }
  list.replaceChildren(...expenses.map(x => Object.assign(document.createElement('li'), { textContent: `${x.title} – ${x.amount} (${x.category})` })));
  const total = expenses.reduce((s, x) => s + x.amount, 0);
  summary.textContent = `Total ${total} → ${grade(total)} | ${JSON.stringify(totalsByCategory(expenses))}`;
  e.target.reset();
});
