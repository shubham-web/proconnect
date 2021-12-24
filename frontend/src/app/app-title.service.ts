import { Injectable } from '@angular/core';
import { Title } from '@angular/platform-browser';
import { AppDataService } from './app-data.service';

@Injectable({
  providedIn: 'root',
})
export class AppTitleService {
  public suffix: string;
  public saperator: string = '•';
  constructor(private appData: AppDataService, private titleService: Title) {
    this.suffix = ` ${this.saperator} ${this.appData.appName}`;
  }
  setTitle(pageTitle: string, withoutSuffix: boolean = false) {
    let title = pageTitle;
    if (!withoutSuffix) {
      title = title.concat(this.suffix);
    }
    this.titleService.setTitle(title);
  }
}
