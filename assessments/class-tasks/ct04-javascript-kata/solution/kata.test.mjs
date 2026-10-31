import test from 'node:test';
import assert from 'node:assert/strict';
import { groupSum, dedupe, makeCounter } from './kata.mjs';

test('groupSum totals per key', () => {
  assert.deepEqual(groupSum([{ c: 'a', v: 1 }, { c: 'a', v: 2 }, { c: 'b', v: 5 }], 'c', 'v'), { a: 3, b: 5 });
  assert.deepEqual(groupSum([], 'c', 'v'), {});
});
test('dedupe keeps first occurrences', () => {
  assert.deepEqual(dedupe([1, 2, 1, 3, 2]), [1, 2, 3]);
  assert.deepEqual(dedupe([]), []);
});
test('makeCounter increases by step', () => {
  const c = makeCounter(5);
  assert.equal(c(), 5);
  assert.equal(c(), 10);
  assert.equal(makeCounter()(), 1);
});
