import { createServer } from 'node:http';
import { EventEmitter } from 'node:events';

const bus = new EventEmitter();
bus.on('request', ({ method, url }) => console.log(new Date().toISOString(), method, url));
const courses = [
  { id: 1, code: 'SEWE-6109', title: 'Web Engineering', credits: 3 },
  { id: 2, code: 'SEDB-5101', title: 'Databases', credits: 3 },
];
const json = (res, code, body) => {
  res.writeHead(code, { 'Content-Type': 'application/json', 'Access-Control-Allow-Origin': '*',
    'Access-Control-Allow-Headers': 'Content-Type' });
  res.end(JSON.stringify(body));
};
createServer(async (req, res) => {
  bus.emit('request', req);
  if (req.method === 'OPTIONS') return json(res, 204, '');
  if (req.url === '/api/courses' && req.method === 'GET') return json(res, 200, courses);
  if (req.url === '/api/courses' && req.method === 'POST') {
    let raw = ''; for await (const chunk of req) raw += chunk;
    try {
      const { code, title, credits } = JSON.parse(raw);
      if (!code || !title || !(credits > 0)) return json(res, 400, { error: 'invalid' });
      const c = { id: courses.length + 1, code, title, credits }; courses.push(c); return json(res, 201, c);
    } catch { return json(res, 400, { error: 'bad json' }); }
  }
  json(res, 404, { error: 'not found' });
}).listen(3000, '127.0.0.1', () => console.log('API on http://127.0.0.1:3000'));
