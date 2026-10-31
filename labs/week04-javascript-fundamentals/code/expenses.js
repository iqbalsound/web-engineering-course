export function addExpense(list, { title, amount, category }) {
  if (!title?.trim()) throw new TypeError('title required');
  if (!Number.isFinite(amount) || amount <= 0) throw new RangeError('amount must be > 0');
  return [...list, { id: list.length + 1, title: title.trim(), amount, category: category ?? 'other' }];
}
export function totalsByCategory(list) {
  const out = {};
  for (const e of list) out[e.category] = (out[e.category] ?? 0) + e.amount;
  return out;
}
export const biggest = list => list.reduce((m, e) => (e.amount > (m?.amount ?? 0) ? e : m), null);
export function grade(total) {
  switch (true) { case total < 5000: return 'frugal'; case total < 20000: return 'normal'; default: return 'high'; }
}
