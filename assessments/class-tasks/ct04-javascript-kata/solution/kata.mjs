export const groupSum = (items, key, valueKey) =>
  items.reduce((acc, it) => { acc[it[key]] = (acc[it[key]] ?? 0) + it[valueKey]; return acc; }, {});
export const dedupe = arr => [...new Set(arr)];
export const makeCounter = (step = 1) => { let n = 0; return () => (n += step); };
// tests: groupSum([{c:'a',v:1},{c:'a',v:2}],'c','v') -> {a:3}; dedupe([1,2,1]) -> [1,2];
//        const c = makeCounter(5); c(); c() -> 10
