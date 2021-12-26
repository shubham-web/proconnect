import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { ApiService } from './api.service';

@Injectable({
  providedIn: 'root',
})
export class ProfileService {
  constructor(private http: HttpClient, private api: ApiService) {}

  getProfileData() {
    return this.http
      .get(this.api.getEndpoint('profile'), {
        headers: { ...this.api.getAuthHeaders() },
      })
      .toPromise();
  }
  saveProfile(updatedData) {
    return this.http
      .put(this.api.getEndpoint('profile'), updatedData, {
        headers: {
          ...this.api.getAuthHeaders(),
        },
      })
      .toPromise();
  }
}
