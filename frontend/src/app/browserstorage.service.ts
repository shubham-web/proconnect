import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root',
})
export class BrowserstorageService {
  static key = 'APP_DATA';

  static fetch(): object {
    let data = localStorage.getItem(this.key);
    if (data === null) {
      return {};
    }
    try {
      return JSON.parse(data);
    } catch (e) {
      this.trunk();
      return {};
    }
  }
  static getItem(key: string) {
    let data = this.fetch();
    return data[key];
  }
  static update(key: string, value: any): object {
    let storage = this.fetch();
    storage[key] = value;

    localStorage.setItem(this.key, JSON.stringify(storage));
    return this.fetch();
  }
  static delete(key: string): boolean {
    let storage = this.fetch();
    delete storage[key];
    localStorage.setItem(this.key, JSON.stringify(storage));
    return true;
  }
  static trunk(): void {
    localStorage.setItem(this.key, JSON.stringify({}));
  }
}
