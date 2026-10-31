import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css';
import { Carousel } from 'bootstrap';

const products = Array.from({ length: 24 }, (_, i) => ({ id: i + 1, name: 'Product ' + (i + 1), price: 500 + i * 125 }));
const PER = 8; let page = 1;
const cards = document.querySelector('#cards'), pager = document.querySelector('#pager');

function render() {
  const slice = products.slice((page - 1) * PER, page * PER);
  cards.innerHTML = slice.map(p => `<div class="col-6 col-md-4 col-lg-3"><div class="card h-100 shadow-sm">
    <div class="card-body d-flex flex-column"><h2 class="h6 card-title">${p.name}</h2>
    <p class="text-body-secondary mb-3">Rs ${p.price.toLocaleString('en-PK')}</p>
    <button class="btn btn-outline-primary mt-auto" data-id="${p.id}"><i class="bi bi-cart-plus"></i> Add</button></div></div></div>`).join('');
  const pages = Math.ceil(products.length / PER);
  pager.innerHTML = Array.from({ length: pages }, (_, i) => i + 1).map(n =>
    `<li class="page-item ${n === page ? 'active' : ''}"><a class="page-link" href="#" data-p="${n}" ${n === page ? 'aria-current="page"' : ''}>${n}</a></li>`).join('');
}
pager.addEventListener('click', e => { const a = e.target.closest('[data-p]'); if (!a) return; e.preventDefault(); page = +a.dataset.p; render(); });

const slides = ['#0f766e', '#7c3aed', '#b45309'].map((c, i) => `<div class="carousel-item ${i ? '' : 'active'}">
  <svg class="d-block w-100" viewBox="0 0 800 260" role="img" aria-label="Offer ${i + 1}"><rect width="800" height="260" fill="${c}"/>
  <text x="400" y="145" fill="#fff" font-size="42" text-anchor="middle">Offer ${i + 1}</text></svg></div>`).join('');
document.querySelector('.carousel-inner').innerHTML = slides;
new Carousel('#hero', { interval: 4000 });

document.querySelector('#theme').addEventListener('click', () => {
  const h = document.documentElement; h.dataset.bsTheme = h.dataset.bsTheme === 'dark' ? 'light' : 'dark';
});
render();
