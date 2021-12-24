import { Component, OnInit } from '@angular/core';
import { AppTitleService } from '../app-title.service';
import { AuthService } from '../auth.service';
import { ProfileService } from '../profile.service';

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.css'],
})
export class ProfileComponent implements OnInit {
  dataLoaded = false;
  basicDetails: {
    firstName: string;
    lastName: string;
  } = {
    firstName: '',
    lastName: '',
  };
  constructor(
    private app: AppTitleService,
    private profileService: ProfileService
  ) {}

  ngOnInit(): void {
    this.app.setTitle('Profile');
    this.profileService
      .getProfileData()
      .then(
        (response: {
          data: { id: string; firstName: string; lastName: string };
        }) => {
          console.log(response);
          this.basicDetails.firstName = response.data.firstName;
          this.dataLoaded = true;
        }
      );
  }
}
