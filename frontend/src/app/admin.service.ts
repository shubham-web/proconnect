import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { MatSnackBar } from '@angular/material/snack-bar';
import { ApiService } from './api.service';

@Injectable({
  providedIn: 'root',
})
export class AdminService {
  constructor(
    private http: HttpClient,
    private api: ApiService,
    private sb: MatSnackBar
  ) {}
  export(asset: 'users' | 'posts') {
    return this.http
      .get(this.api.getEndpoint(`admin/${asset}/export`), {
        headers: { ...this.api.getAuthHeaders() },
        responseType: 'blob',
      })
      .toPromise();
  }
  fetchUsers(pageSize: number, currentPage: number) {
    let offset = pageSize * (currentPage - 1);
    let limit = pageSize;
    return this.http
      .get(
        this.api.getEndpoint(
          false ? `admin/users` : `admin/users/${offset}/${limit}`
        ),
        {
          headers: { ...this.api.getAuthHeaders() },
        }
      )
      .toPromise();
  }
  fetchPosts(pageSize: number, currentPage: number) {
    let offset = pageSize * (currentPage - 1);
    let limit = pageSize;
    return this.http
      .get(
        this.api.getEndpoint(
          false ? `admin/posts` : `admin/posts/${offset}/${limit}`
        ),
        {
          headers: { ...this.api.getAuthHeaders() },
        }
      )
      .toPromise();
  }
  changeUserStatus(userId, updatedData) {
    return this.http
      .put(this.api.getEndpoint(`admin/user/${userId}`), updatedData, {
        headers: { ...this.api.getAuthHeaders() },
      })
      .toPromise();
  }
  changePostStatus(postId, updatedData) {
    return this.http
      .put(this.api.getEndpoint(`admin/post/${postId}`), updatedData, {
        headers: { ...this.api.getAuthHeaders() },
      })
      .toPromise();
  }
  deleteUser(userId) {
    return this.http
      .delete(this.api.getEndpoint(`admin/user/${userId}`), {
        headers: { ...this.api.getAuthHeaders() },
      })
      .toPromise();
  }
  exportData(asset: 'users' | 'posts') {
    this.export(asset)
      .then((csvBlob) => {
        let a = document.createElement('a');
        a.href = URL.createObjectURL(csvBlob);
        a.download = `${asset}.csv`;
        a.click();
      })
      .catch((errResp) => {
        console.debug(errResp);
        this.sb.open(errResp.error.message || 'Something went wrong!', '', {
          duration: 3000,
          horizontalPosition: 'center',
          verticalPosition: 'bottom',
          panelClass: 'sb_error',
        });
      });
  }
  importData(csvData: object) {
    return this.http
      .post(this.api.getEndpoint(`admin/users/import`), csvData, {
        headers: { ...this.api.getAuthHeaders() },
      })
      .toPromise();
  }
}
