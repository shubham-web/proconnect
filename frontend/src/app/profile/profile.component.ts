import { Component, OnChanges, OnInit, SimpleChanges } from '@angular/core';
import { MatSnackBar } from '@angular/material/snack-bar';
import { AppTitleService } from '../app-title.service';
import { AuthService } from '../auth.service';
import { ProfileService } from '../profile.service';

interface ProfileData {
  firstName: string;
  lastName: string;
  email: string;
  mobile: string;
  dob: string;
  profileHeader: string;
  metadata: {
    dp: string;
    experience: string;
    education: string;
    profileViews: string;
  };
}

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.css'],
})
export class ProfileComponent implements OnInit, OnChanges {
  dataLoaded = false;
  editMode = false;
  profileData: ProfileData = {
    firstName: '',
    lastName: '',
    email: '',
    mobile: '',
    dob: '',
    profileHeader: '',
    metadata: {
      dp: '',
      experience: '',
      education: '',
      profileViews: '',
    },
  };
  initialData = this.profileData;
  metadata: object;
  constructor(
    private app: AppTitleService,
    private profileService: ProfileService,
    private sb: MatSnackBar,
    private auth: AuthService
  ) {}
  ngOnChanges(changes: SimpleChanges): void {
    console.log('changes', changes);
  }

  ngOnInit(): void {
    this.app.setTitle('Profile');
    this.profileService
      .getProfileData()
      .then((response: { data: ProfileData }) => {
        console.log(response);
        if (response.data.metadata === null) {
          response.data.metadata = this.profileData.metadata;
        }
        console.log(response.data);
        this.profileData = response.data;
        this.initialData = JSON.parse(JSON.stringify(this.profileData));
        this.dataLoaded = true;
      })
      .catch((errResp) => {
        this.sb.open(errResp.error.message || 'Something went wrong!', '', {
          horizontalPosition: 'center',
          verticalPosition: 'bottom',
          panelClass: 'sb_error',
        });
      });
  }
  cancelEdits() {
    this.profileData = this.initialData;
    this.editMode = false;
  }
  saveEdits() {
    let updatedData = this.profileData;
    /* if (updatedData.firstName !== this.initialData.firstName) {
    } */
    this.profileService
      .saveProfile(updatedData)
      .then((response: any) => {
        console.log(response);
        this.sb.open('Changes Saved!', '', {
          duration: 3000,
          horizontalPosition: 'center',
          verticalPosition: 'bottom',
          panelClass: 'sb_success',
        });
        this.initialData = JSON.parse(JSON.stringify(this.profileData));
      })
      .catch(console.log)
      .finally(() => {
        this.auth.userCheck(true);
        this.editMode = false;
      });
  }
}
