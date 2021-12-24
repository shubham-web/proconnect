import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable, EventEmitter } from '@angular/core';
import { ApiService } from './api.service';
import { BrowserstorageService } from './browserstorage.service';
import { SessionService } from './session.service';

@Injectable({
  providedIn: 'root',
})
export class AuthService {
  constructor(private http: HttpClient, private api: ApiService) {}
  authUpdated = new EventEmitter();
  isLoggedIn() {
    return !!this.getCurrentUser();
  }
  logout() {
    SessionService.delete('currentUser');
    BrowserstorageService.delete('token');
    return true;
  }
  getCurrentUser() {
    return SessionService.getItem('currentUser');
  }
  userCheck() {
    return new Promise((resolve) => {
      let token = BrowserstorageService.getItem('token');
      if (!token) {
        SessionService.delete('currentUser');
        resolve(null);
        return;
      }

      let currentUser = SessionService.getItem('currentUser');
      if (currentUser) {
        resolve(currentUser);
        return;
      }
      this.check(token)
        .then((response: { success: object; data: object }) => {
          SessionService.update('currentUser', response.data);
          // this.loggedIn = true;
          resolve(currentUser);
        })
        .catch((errResp) => {
          console.debug(errResp);
          resolve(null);
        });
    });
  }
  check(token) {
    return this.http
      .get(this.api.getEndpoint('me'), {
        headers: { Authorization: token },
      })
      .toPromise();
  }
  login(data: {}) {
    return this.http.post(this.api.getEndpoint('login'), data).toPromise();
  }
}
