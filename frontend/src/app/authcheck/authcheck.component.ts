import { Component, Input, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { AuthService } from '../auth.service';

@Component({
  selector: 'app-authcheck',
  templateUrl: './authcheck.component.html',
  styleUrls: ['./authcheck.component.css'],
})
export class AuthcheckComponent implements OnInit {
  @Input('role') role: string = 'USER';
  @Input('redirectIfFails') redirectIfFails: boolean = false;
  authorized = false;
  constructor(private auth: AuthService, private route: Router) {}

  ngOnInit(): void {
    let currentUser = this.auth.getCurrentUser();
    if (!!currentUser === false) {
      this.handleFailure();
      return;
    }
    this.authorized = this.role === currentUser?.role;
  }
  handleFailure() {
    if (this.redirectIfFails === false) {
      return;
    }
    this.route.navigateByUrl('/login');
  }
}
