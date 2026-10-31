import { readFile } from 'node:fs';
import { readFile as readP } from 'node:fs/promises';
// 1) callback style (error-first, nesting grows)
readFile('package.json', 'utf8', (err, data) => { if (err) return console.error(err); console.log('cb', data.length); });
// 2) promise style
readP('package.json', 'utf8').then(d => console.log('promise', d.length)).catch(console.error);
// 3) async/await
try { console.log('await', (await readP('package.json', 'utf8')).length); } catch (e) { console.error(e); }
