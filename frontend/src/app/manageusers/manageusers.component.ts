import { Component, OnChanges, OnInit, SimpleChanges } from '@angular/core';
import { PageEvent } from '@angular/material/paginator';
import { MatSnackBar } from '@angular/material/snack-bar';
import { AdminService } from '../admin.service';
import { AppTitleService } from '../app-title.service';

@Component({
  selector: 'app-manageusers',
  templateUrl: './manageusers.component.html',
  styleUrls: ['./manageusers.component.css'],
})
export class ManageusersComponent implements OnInit {
  objectKeys = Object.keys;
  pageSize: number = 5;
  currentPage: number = 1;
  users: any[];
  total: number;
  constructor(
    private appTitle: AppTitleService,
    private adminService: AdminService,
    private sb: MatSnackBar
  ) {}

  ngOnInit(): void {
    this.appTitle.setTitle('Manage Users');
    this.fetchUsers();
  }
  fetchUsers() {
    this.adminService
      .fetchUsers(this.pageSize, this.currentPage)
      .then((response: any) => {
        let data = response.data;
        this.users = data.users;
        this.total = data.total;
      })
      .catch((errResp) => {
        this.sb.open(errResp.error.message || 'Something went wrong!', '', {
          duration: 3000,
          horizontalPosition: 'center',
          verticalPosition: 'bottom',
          panelClass: 'sb_error',
        });
      });
  }
  formatDate(date) {
    return new Date(date).toDateString();
  }
  toggleStatus(userId) {
    console.log('toggleStatus', userId);
    let targetUser = this.users.find((user) => user.id === userId);
    console.log(targetUser);
    let updatedStatus =
      targetUser.status === 'VERIFIED' ? 'SUSPENDED' : 'VERIFIED';
    this.adminService
      .changeUserStatus(userId, {
        status: updatedStatus,
      })
      .then((response: any) => {
        targetUser.status = updatedStatus;
      })
      .catch((errResp) => {
        this.sb.open(errResp.error.message || 'Something went wrong!', '', {
          duration: 3000,
          horizontalPosition: 'center',
          verticalPosition: 'bottom',
          panelClass: 'sb_error',
        });
      });
  }
  deleteUser(userId) {
    let deleted = confirm('Are you sure?');
    if (!deleted) {
      return;
    }
    this.adminService
      .deleteUser(userId)
      .then((response) => {
        console.log(response);
        this.users = this.users.filter((user) => user.id !== userId);
      })
      .catch((errResp) => {
        this.sb.open(errResp.error.message || 'Something went wrong!', '', {
          duration: 3000,
          horizontalPosition: 'center',
          verticalPosition: 'bottom',
          panelClass: 'sb_error',
        });
      });
  }
  export() {
    this.adminService.exportData('users');
  }
  import() {
    let input = document.createElement('input');
    input.type = 'file';
    input.accept = 'text/csv';
    input.addEventListener('change', async (e) => {
      let file = input.files[0];
      let url = URL.createObjectURL(file);
      let csvData = await fetch(url).then((e) => e.text());
      console.log(csvData);
      this.adminService
        .importData({
          csv: csvData,
        })
        .then(() => {
          this.sb.open('Users Imported Successfully!', '', {
            duration: 3000,
            horizontalPosition: 'center',
            verticalPosition: 'bottom',
            panelClass: 'sb_success',
          });
          this.fetchUsers();
        })
        .catch((errResp) => {
          this.sb.open(errResp.error.message || 'Something went wrong!', '', {
            duration: 3000,
            horizontalPosition: 'center',
            verticalPosition: 'bottom',
            panelClass: 'sb_error',
          });
        });
    });
    input.click();
  }
  onPageChange(eve) {
    console.log(eve);
    this.currentPage = eve.pageIndex + 1;
    this.fetchUsers();
  }
}
