import { Component, OnInit } from '@angular/core';
import { MatSnackBar } from '@angular/material/snack-bar';
import { Title } from '@angular/platform-browser';
import { Router } from '@angular/router';
import { environment } from 'src/environments/environment';
import { ApiService } from '../api.service';
import { AppTitleService } from '../app-title.service';
import { AuthService } from '../auth.service';
import { PostsService } from '../posts.service';
import { ProfileService } from '../profile.service';

@Component({
  selector: 'app-feed',
  templateUrl: './feed.component.html',
  styleUrls: ['./feed.component.css'],
})
export class FeedComponent implements OnInit {
  pageSize = 10;
  currentPage = 1;
  posts = [];
  connections = [];
  constructor(
    private sb: MatSnackBar,
    private app: AppTitleService,
    public auth: AuthService,
    private postService: PostsService,
    private profileService: ProfileService,
    public api: ApiService
  ) {}
  userUri = 'https://bellfund.ca/wp-content/uploads/2018/03/demo-user.jpg';
  ngOnInit(): void {
    this.app.setTitle('Feed');
    this.fetchPosts();
    this.fetchConnections();
    this.postService.newPostAdded.subscribe(() => {
      this.fetchPosts();
    });
  }
  fetchPosts() {
    this.postService
      .getFeedPosts(this.pageSize, this.currentPage)
      .then((response: any) => {
        this.posts = this.filterPosts(response.data);
      });
  }
  fetchConnections() {
    this.postService.getConnections().then((response: any) => {
      this.connections = response.data;
    });
  }
  filterPosts(posts) {
    posts = posts.map((post) => {
      post.createdAt = new Date(post.createdAt).toDateString();
      return post;
    });
    return posts;
  }
  deletePost(postId) {
    let confirmed = confirm(`Delete post #${postId}?`);
    if (!confirmed) {
      return;
    }
    this.postService
      .deletePost(postId)
      .then((response: any) => {
        this.sb.open(response.message, '', {
          duration: 3000,
          horizontalPosition: 'center',
          verticalPosition: 'bottom',
          panelClass: 'sb_success',
        });
        this.fetchPosts();
      })
      .catch(console.log);
  }
  likePost(postId) {
    let targetPost = this.posts.find((post) => post.id === postId);
    this.postService
      .likePost(postId)
      .then((response: any) => {
        targetPost.likes = response.data.likes;
        targetPost.liked = !targetPost.liked;
      })
      .catch(console.log);
  }
  countLikes(likes: string = '') {
    if (!likes) {
      return 0;
    }
    return likes.split(',').length;
  }
}
