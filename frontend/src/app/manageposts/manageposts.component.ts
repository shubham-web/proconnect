import { Component, OnInit } from '@angular/core';
import { MatSnackBar } from '@angular/material/snack-bar';
import { AdminService } from '../admin.service';
import { AppTitleService } from '../app-title.service';

@Component({
  selector: 'app-manageposts',
  templateUrl: './manageposts.component.html',
  styleUrls: ['./manageposts.component.css'],
})
export class ManagepostsComponent implements OnInit {
  objectKeys = Object.keys;
  pageSize: number = 5;
  currentPage: number = 1;
  posts: any[];
  total: number;
  constructor(
    private appTitle: AppTitleService,
    private adminService: AdminService,
    private sb: MatSnackBar
  ) {}

  ngOnInit(): void {
    this.appTitle.setTitle('Manage Posts');
    this.fetchPosts();
  }
  fetchPosts() {
    this.adminService
      .fetchPosts(this.pageSize, this.currentPage)
      .then((response: any) => {
        let data = response.data;
        this.posts = data.posts;
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
  toggleStatus(postId) {
    console.log('toggleStatus', postId);
    let targetPost = this.posts.find((post) => post.id === postId);
    console.log(targetPost);
    let updatedStatus = targetPost.status === 'ACTIVE' ? 'SUSPENDED' : 'ACTIVE';
    this.adminService
      .changePostStatus(postId, {
        status: updatedStatus,
      })
      .then((response: any) => {
        targetPost.status = updatedStatus;
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
    this.adminService.exportData('posts');
  }
  onPageChange(eve) {
    this.currentPage = eve.pageIndex + 1;
    this.fetchPosts();
  }
  shorten(str: string, max = 20) {
    if (str.length < max) return str;
    return str.slice(0, 60).concat('...');
  }
  countLikes(likes: string = '') {
    if (!likes) {
      return 0;
    }
    return likes.split(',').length;
  }
}
