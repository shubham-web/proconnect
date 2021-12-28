import { Component, OnInit } from '@angular/core';
import { MatSnackBar } from '@angular/material/snack-bar';
import { ApiService } from '../api.service';
import { AuthService } from '../auth.service';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css'],
})
export class RegisterComponent implements OnInit {
  constructor(
    private apiService: ApiService,
    private authService: AuthService,
    private sb: MatSnackBar
  ) {}

  firstName: string = '';
  lastName: string = '';

  country: string = '101';
  email: string = 'shubhamp@indiaskills.com';
  mobile: string = '';
  dob: string = '09-09-2021';

  password: string = '';
  confpassword: string = '';

  currentStep: number = 1;
  countries: [];
  fetching: boolean = false;
  loadingCountries: boolean = false;
  ngOnInit(): void {
    this.apiService
      .getCountries()
      .then((response: any) => {
        this.countries = response.data;
      })
      .catch(console.log);
  }

  async submitForm() {
    if (this.currentStep === 1) {
      let alreadyExists = await this.userExists();
      if (alreadyExists) {
        this.sb.open('A user with this email already exists.', '', {
          duration: 3000,
          panelClass: 'sb_error',
        });
      } else {
        this.currentStep = 2;
      }
      return;
    }

    if (this.currentStep !== 2) {
      return;
    }
    // on second step
  }
  userExists() {
    return new Promise((resolve, reject) => {
      this.authService
        .userExists(this.email)
        .then((response: any) => {
          resolve(!!response.data.alreadyExists);
        })
        .catch((errResp) => {
          resolve(false);
        });
    });
  }
  changeEmail() {
    this.currentStep = 1;
  }
}
