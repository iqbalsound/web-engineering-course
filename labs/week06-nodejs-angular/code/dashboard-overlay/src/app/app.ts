import { Component, inject, signal, computed } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { FormsModule } from '@angular/forms';

interface Course { id: number; code: string; title: string; credits: number; }

@Component({ selector: 'app-root', imports: [FormsModule], templateUrl: './app.html', styleUrl: './app.css' })
export class App {
  private http = inject(HttpClient);
  private api = 'http://127.0.0.1:3000/api/courses';
  courses = signal<Course[]>([]);
  query = signal('');
  draft = { code: '', title: '', credits: 3 };
  filtered = computed(() => this.courses().filter(c => (c.code + c.title).toLowerCase().includes(this.query().toLowerCase())));
  totalCredits = computed(() => this.filtered().reduce((s, c) => s + c.credits, 0));
  constructor() { this.load(); }
  load() { this.http.get<Course[]>(this.api).subscribe(d => this.courses.set(d)); }
  add() { this.http.post<Course>(this.api, this.draft).subscribe(c => { this.courses.update(l => [...l, c]); this.draft = { code: '', title: '', credits: 3 }; }); }
}
