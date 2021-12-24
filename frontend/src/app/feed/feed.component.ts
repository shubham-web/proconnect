import { Component, OnInit } from '@angular/core';
import { Title } from '@angular/platform-browser';
import { Router } from '@angular/router';
import { AppTitleService } from '../app-title.service';
import { AuthService } from '../auth.service';

@Component({
  selector: 'app-feed',
  templateUrl: './feed.component.html',
  styleUrls: ['./feed.component.css'],
})
export class FeedComponent implements OnInit {
  constructor(private app: AppTitleService) {}

  ngOnInit(): void {
    this.app.setTitle('Feed');
  }
}
