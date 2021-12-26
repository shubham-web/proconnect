import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { ApiService } from './api.service';
import { AppTitleService } from './app-title.service';

@Injectable({
  providedIn: 'root',
})
export class AppDataService {
  appName: string = 'ProConnect';
  constants = {
    roles: {
      USER: 'USER',
      ADMIN: 'ADMIN',
    },
  };
  retry = true;
  retryCount = 5;
  interval = 1500;
  currentIteration = 0;
  logs = [];

  constructor(private http: HttpClient, private api: ApiService) {}
  pingServer(freshRequest = false) {
    if (freshRequest) {
      this.currentIteration = 0;
    }
    this.http
      .get(this.api.getEndpoint('beat'))
      .toPromise()
      .then((response) => {
        this.logs.push(JSON.stringify(response));
      })
      .catch((err) => {
        if (this.retry) {
          if (this.currentIteration >= this.retryCount) {
            return;
          }
          setTimeout(() => {
            this.currentIteration++;
            this.pingServer();
          }, this.interval);
        }
        this.logs.push(err.message);
      });
  }
}
