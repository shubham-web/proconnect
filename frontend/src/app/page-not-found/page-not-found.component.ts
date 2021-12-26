import { Location } from '@angular/common';
import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { AppTitleService } from '../app-title.service';

@Component({
  selector: 'app-page-not-found',
  templateUrl: './page-not-found.component.html',
  styleUrls: ['./page-not-found.component.css'],
})
export class PageNotFoundComponent implements OnInit {
  constructor(
    private app: AppTitleService,
    private route: Router,
    private location: Location
  ) {}

  goBack() {
    this.location.back();
  }
  goHome() {
    this.route.navigateByUrl('/');
  }
  ngOnInit(): void {
    this.app.setTitle('Page not found');
  }
}
