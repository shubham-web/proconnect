import { Component, OnChanges, OnInit, SimpleChanges } from '@angular/core';
import { Router } from '@angular/router';
import { AuthService } from '../auth.service';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.css'],
})
export class HeaderComponent implements OnInit, OnChanges {
  constructor(public auth: AuthService, private route: Router) {}

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
