const wait = ms => new Promise(res => setTimeout(() => res(ms), ms));   // or util.promisify(wait)
const getUser = async id => { await wait(100); if (id <= 0) throw new Error('bad id'); return { id }; };
try {
  console.log(await Promise.all([1, 2, 3].map(getUser)));   // concurrent: ~100 ms, not 300 ms
  await getUser(0);
} catch (e) { console.error('Handled:', e.message); }
