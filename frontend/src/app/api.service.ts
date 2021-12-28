import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';
import { BrowserstorageService } from './browserstorage.service';

@Injectable({
  providedIn: 'root',
})
export class ApiService {
  private url = environment.apiBase;
  constructor(private http: HttpClient) {}
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
  getHeaders() {
    return {
      ...this.getAuthHeaders(),
    };
  }
  securedGet(url) {
    return this.http
      .get(url, {
        headers: this.getHeaders(),
      })
      .toPromise();
  }
  securedPost(url: string, data: object) {
    return this.http
      .post(url, data, {
        headers: this.getHeaders(),
      })
      .toPromise();
  }
  securedDelete(url: string) {
    return this.http
      .delete(url, {
        headers: this.getHeaders(),
      })
      .toPromise();
  }
  upload(file, dir) {
    let formData = new FormData();
    formData.append('file[]', file);
    formData.append('dir', dir);
    return this.http
      .post(this.getEndpoint('upload'), formData, {
        headers: this.getHeaders(),
      })
      .toPromise();
  }
  getServerUrl(path: string) {
    return environment.serverAssets.concat(path);
  }

  getCountries() {
    return this.http.get(this.getEndpoint('countries')).toPromise();
  }
}
