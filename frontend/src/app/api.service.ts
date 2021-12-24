import { Injectable } from '@angular/core';
import { BrowserstorageService } from './browserstorage.service';

@Injectable({
  providedIn: 'root',
})
export class ApiService {
  private url = 'http://localhost:8080';
  constructor() {}
  getEndpoint(path: string = '') {
    if (!path.startsWith('/')) {
      path = `/${path}`;
    }
    return this.url.concat(path);
  }
  getAuthHeaders() {
    return {
      Authorization: BrowserstorageService.getItem('token'),
    };
  }
}
