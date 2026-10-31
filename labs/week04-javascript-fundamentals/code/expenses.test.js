import test from 'node:test';
import assert from 'node:assert/strict';
import { addExpense, totalsByCategory, biggest, grade } from './expenses.js';

test('addExpense validates input', () => {
  assert.throws(() => addExpense([], { title: '', amount: 5 }), TypeError);
  assert.throws(() => addExpense([], { title: 'x', amount: -1 }), RangeError);
});
test('totalsByCategory groups amounts', () => {
  let l = addExpense([], { title: 'Bus', amount: 100, category: 'travel' });
  l = addExpense(l, { title: 'Lunch', amount: 300, category: 'food' });
  l = addExpense(l, { title: 'Taxi', amount: 400, category: 'travel' });
  assert.deepEqual(totalsByCategory(l), { travel: 500, food: 300 });
  assert.equal(biggest(l).title, 'Taxi');
});
test('grade thresholds', () => { assert.equal(grade(100), 'frugal'); assert.equal(grade(30000), 'high'); });
