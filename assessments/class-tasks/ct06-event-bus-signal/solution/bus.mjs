import { EventEmitter } from 'node:events';
const bus = new EventEmitter();
bus.on('order', id => console.log('log', id));
bus.on('order', id => console.log('email', id));
bus.on('order', id => console.log('stock', id));
bus.once('order', id => console.log('first order only', id));
bus.emit('order', 1); bus.emit('order', 2);
// output: log 1, email 1, stock 1, first order only 1, log 2, email 2, stock 2
