import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root',
})
export class Logger {
  constructor() {}
  static log(data: any) {
    if (!environment.logs) {
      return;
    }
    let timestamp =
      new Date().toLocaleDateString() + ' ' + new Date().toLocaleTimeString();
    console.log(timestamp.concat(' ', JSON.stringify(data)));
  }
}
