import { Component, OnChanges, OnInit, SimpleChanges } from '@angular/core';
import { MatSnackBar } from '@angular/material/snack-bar';
import { ApiService } from '../api.service';
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
  dp: string;
  metadata: {
    experience: string;
    education: string;
    profileViews: number;
  };
}
interface EducationPopup {
  institute: string;
  course: string;
  stream: string;
  startDate: string;
  endDate: string | null;
}
interface ExperiencePopup {
  company: string;
  title: string;
  startDate: string;
  endDate: string | null;
}

interface PopupConfig {
  resource: string;
  heading: string;
  state: EducationPopup | ExperiencePopup;
}

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.css'],
})
export class ProfileComponent implements OnInit, OnChanges {
  dataLoaded = false;
  editMode = false;
  popupOpened: boolean = true;
  profileData: ProfileData = {
    firstName: '',
    lastName: '',
    email: '',
    mobile: '',
    dob: '',
    dp: '',
    profileHeader: '',
    metadata: {
      experience: null,
      education: null,
      profileViews: 0,
    },
  };
  popups: {
    education: EducationPopup;
    experience: ExperiencePopup;
  } = {
    education: {
      institute: '',
      course: '',
      stream: '',
      startDate: '',
      endDate: null,
    },
    experience: {
      company: '',
      title: '',
      startDate: '',
      endDate: null,
    },
  };
  metaPopup: PopupConfig = {
    resource: 'education',
    heading: 'Add Education',
    state: this.popups.education,
  };

  initialData = this.profileData;
  metadata: object;
  constructor(
    private app: AppTitleService,
    public profileService: ProfileService,
    private sb: MatSnackBar,
    private auth: AuthService,
    private api: ApiService
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
          console.log(this.profileData.metadata);
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
  changeDp() {
    let input = document.createElement('input');
    input.type = 'file';
    input.accept = 'image/jpg,image/png,image/jpeg';
    input.addEventListener('change', async () => {
      let file = input.files[0];
      let response: any = await this.api
        .upload(file, 'profile')
        .catch(console.log);
      if (response) {
        this.profileService
          .saveProfile({
            dp: response.data[0].path,
          })
          .then((response: any) => {
            this.auth.userCheck(true);
            this.profileData.dp = response.data.dp;
          })
          .catch(console.log);
      }
    });
    input.click();
  }
  addEducation() {
    this.popupOpened = true;
  }
}
