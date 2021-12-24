import { Injectable } from '@angular/core';
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
  constructor() {}
}
