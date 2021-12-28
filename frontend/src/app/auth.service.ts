import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable, EventEmitter } from '@angular/core';
import { ApiService } from './api.service';
import { BrowserstorageService } from './browserstorage.service';
import { SessionService } from './session.service';
import { MatSnackBar } from '@angular/material/snack-bar';

@Injectable({
  providedIn: 'root',
})
export class AuthService {
  constructor(
    private http: HttpClient,
    private api: ApiService,
    private sb: MatSnackBar
  ) {}
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
  userCheck(forceRefresh = false) {
    return new Promise((resolve) => {
      let token = BrowserstorageService.getItem('token');
      if (!token) {
        SessionService.delete('currentUser');
        resolve(null);
        return;
      }

      let currentUser = SessionService.getItem('currentUser');
      if (currentUser && !forceRefresh) {
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
          this.sb.open(errResp.error.message || 'Something went wrong!', '', {
            duration: 3000,
            horizontalPosition: 'center',
            verticalPosition: 'bottom',
            panelClass: 'sb_error',
          });
          this.logout();
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
  userExists(email: string) {
    return this.http
      .post(this.api.getEndpoint('/user-exists'), { email: email })
      .toPromise();
  }
}
