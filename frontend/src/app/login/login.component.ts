import { Component, OnInit } from '@angular/core';
import { AuthService } from '../auth.service';
import { MatSnackBar } from '@angular/material/snack-bar';
import { BrowserstorageService } from '../browserstorage.service';
import { AppTitleService } from '../app-title.service';
import { AppDataService } from '../app-data.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css'],
})
export class LoginComponent implements OnInit {
  emailOrMobile: string = 'pritam@indiaskills.com';
  password: string = 'pritam_secret';
  fetching: boolean = false;

  constructor(
    private auth: AuthService,
    private sb: MatSnackBar,
    private appTitle: AppTitleService,
    private appData: AppDataService,
    private route: Router
  ) {}

  submitForm() {
    if (this.fetching) {
      // already fetching
      return;
    }
    this.fetching = true;
    this.auth
      .login({
        emailOrMobile: this.emailOrMobile,
        password: this.password,
      })
      .then((response: any) => {
        BrowserstorageService.update('token', response?.data?.token);
        this.auth.userCheck().then(() => {
          this.redirectUserBasedOnRole(response.data.targetUser.role);
        });
      })
      .catch((errResp) => {
        this.sb.open(errResp.error.message, '', {
          duration: 3000,
          horizontalPosition: 'center',
          verticalPosition: 'bottom',
          panelClass: 'sb_error',
        });
      })
      .finally(() => {
        this.fetching = false;
        // this.auth.authUpdated.emit();
      });
  }
  ngOnInit(): void {
    this.appTitle.setTitle('Login');
    if (!this.auth.isLoggedIn()) {
      return;
    }
    this.redirectUserBasedOnRole(this.auth.getCurrentUser().role);
  }
  redirectUserBasedOnRole(role: 'USER' | 'ADMIN') {
    if (role === 'USER') {
      this.route.navigateByUrl('/feed');
    } else if (role === 'ADMIN') {
      this.route.navigateByUrl('/admin');
    }
  }
}
