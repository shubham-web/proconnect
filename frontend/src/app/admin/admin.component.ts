import { Component, OnInit } from '@angular/core';
import { MatSnackBar } from '@angular/material/snack-bar';
import { AdminService } from '../admin.service';
import { AppTitleService } from '../app-title.service';

@Component({
  selector: 'app-admin',
  templateUrl: './admin.component.html',
  styleUrls: ['./admin.component.css'],
})
export class AdminComponent implements OnInit {
  constructor(
    private appTitle: AppTitleService,
    private adminService: AdminService,
    private sb: MatSnackBar
  ) {}

  ngOnInit(): void {
    this.appTitle.setTitle('Admin');
  }
  export(asset: 'users' | 'posts') {
    this.adminService
      .export(asset)
      .then((csvBlob) => {
        let a = document.createElement('a');
        a.href = URL.createObjectURL(csvBlob);
        a.download = `${asset}.csv`;
        a.click();
      })
      .catch((errResp) => {
        console.debug(errResp);
        this.sb.open(errResp.error.message || 'Something went wrong!', '', {
          duration: 3000,
          horizontalPosition: 'center',
          verticalPosition: 'bottom',
          panelClass: 'sb_error',
        });
      });
  }
}
