import { Component, OnChanges, OnInit, SimpleChanges } from '@angular/core';
import { Router } from '@angular/router';
import { ApiService } from '../api.service';
import { AuthService } from '../auth.service';
import { ProfileService } from '../profile.service';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.css'],
})
export class HeaderComponent implements OnInit, OnChanges {
  constructor(
    public auth: AuthService,
    private route: Router,
    public api: ApiService,
    public profileService: ProfileService
  ) {}

  ngOnInit(): void {
    this.auth.authUpdated.subscribe(() => {
      console.log('auth updated!!');
    });
  }
  ngOnChanges(changes: SimpleChanges): void {
    console.log(changes);
  }
  logout() {
    this.auth.logout();
    this.route.navigateByUrl('/login');
  }
}
