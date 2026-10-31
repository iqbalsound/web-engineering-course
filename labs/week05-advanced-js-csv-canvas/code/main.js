import Papa from 'papaparse';
import * as THREE from 'three';

const EMAIL = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
class Student {
  #marks;
  constructor(row) { Object.assign(this, { id: row.id, name: row.name, email: row.email }); this.marks = row.marks; }
  get marks() { return this.#marks; }
  set marks(v) { const n = Number(v); if (!Number.isFinite(n) || n < 0 || n > 100) throw new RangeError('0-100'); this.#marks = n; }
  get grade() { return this.marks >= 85 ? 'A' : this.marks >= 70 ? 'B' : 'C'; }
}
const base = import.meta.env.BASE_URL;
const text = await (await fetch(base + 'students.csv')).text();
const rows = Papa.parse(text, { header: true, skipEmptyLines: true }).data;
const students = rows.map(r => new Student(r));
const tbody = document.querySelector('#t tbody'), msg = document.querySelector('#msg');

function render() {
  tbody.replaceChildren(...students.map((s, i) => {
    const tr = document.createElement('tr');
    const ok = EMAIL.test(s.email);
    tr.innerHTML = '<td></td><td></td><td></td><td contenteditable="true" data-i="' + i + '"></td><td></td>';
    const c = tr.children;
    c[0].textContent = s.id; c[1].textContent = s.name; c[2].textContent = s.email + (ok ? '' : '  ⚠ invalid');
    c[3].textContent = s.marks; c[4].textContent = s.grade;
    return tr;
  }));
}
tbody.addEventListener('focusout', e => {            // event delegation
  const td = e.target.closest('td[data-i]'); if (!td) return;
  try { students[td.dataset.i].marks = td.textContent; msg.textContent = 'saved'; }
  catch { msg.textContent = 'Marks must be 0-100'; }
  render();
});
document.querySelector('#export').addEventListener('click', () => {
  const csv = Papa.unparse(students.map(s => ({ id: s.id, name: s.name, email: s.email, marks: s.marks })));
  const a = Object.assign(document.createElement('a'), { href: URL.createObjectURL(new Blob([csv], { type: 'text/csv' })), download: 'students-out.csv' });
  a.click(); URL.revokeObjectURL(a.href);
});
render();

// 2D canvas rotation
const ctx = document.querySelector('#c2d').getContext('2d'); let ang = 0;
(function frame() { ctx.clearRect(0, 0, 200, 200); ctx.save(); ctx.translate(100, 100); ctx.rotate(ang += 0.03);
  ctx.fillStyle = '#0f766e'; ctx.fillRect(-35, -35, 70, 70); ctx.restore(); requestAnimationFrame(frame); })();

// 3D cube
const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true }); renderer.setSize(220, 220);
document.querySelector('#c3d').append(renderer.domElement);
const scene = new THREE.Scene(), cam = new THREE.PerspectiveCamera(60, 1, 0.1, 10); cam.position.z = 2.2;
const cube = new THREE.Mesh(new THREE.BoxGeometry(1, 1, 1), new THREE.MeshNormalMaterial()); scene.add(cube);
renderer.setAnimationLoop(() => { cube.rotation.x += 0.01; cube.rotation.y += 0.015; renderer.render(scene, cam); });
