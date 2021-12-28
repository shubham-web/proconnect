import { Component, HostListener, OnInit } from '@angular/core';
import { MatSnackBar } from '@angular/material/snack-bar';
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
  pageSize = 5;
  currentPage = 1;
  posts = [];
  connections = [];
  constructor(
    private sb: MatSnackBar,
    private app: AppTitleService,
    public auth: AuthService,
    private postService: PostsService,
    public profileService: ProfileService,
    public api: ApiService
  ) {}

  ngOnInit(): void {
    this.app.setTitle('Feed');
    this.fetchPosts();
    this.fetchConnections();
    this.postService.newPostAdded.subscribe(() => {
      this.fetchPosts();
    });
  }
  @HostListener('window:scroll')
  onScrollHandler() {
    let currentPosition =
      document.documentElement.scrollTop +
      document.documentElement.offsetHeight;
    let maxHeight = document.documentElement.scrollHeight;

    if (currentPosition >= maxHeight) {
      this.currentPage++;
      this.fetchPosts();
    }
  }
  fetchPosts() {
    this.postService
      .getFeedPosts(this.pageSize, this.currentPage)
      .then((response: any) => {
        this.posts.push(...this.filterPosts(response.data));
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
