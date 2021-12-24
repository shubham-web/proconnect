import { Component, OnInit } from '@angular/core';
import { AppTitleService } from '../app-title.service';

@Component({
  selector: 'app-page-not-found',
  templateUrl: './page-not-found.component.html',
  styleUrls: ['./page-not-found.component.css'],
})
export class PageNotFoundComponent implements OnInit {
  constructor(private app: AppTitleService) {}

  ngOnInit(): void {
    this.app.setTitle('Page not found');
  }
}
