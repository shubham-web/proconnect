import { EventEmitter, Injectable } from '@angular/core';
import { ApiService } from './api.service';

@Injectable({
  providedIn: 'root',
})
export class PostsService {
  constructor(private api: ApiService) {}
  newPostAdded = new EventEmitter();
  getFeedPosts(pageSize: number, currentPage: number) {
    let offset = pageSize * (currentPage - 1);
    let limit = pageSize;
    return this.api.securedGet(
      this.api.getEndpoint(`posts/${offset}/${limit}`)
    );
  }
  publishNewPost(data: object) {
    return this.api.securedPost(this.api.getEndpoint('post'), data);
  }
  deletePost(postId: number) {
    return this.api.securedDelete(this.api.getEndpoint(`post/${postId}`));
  }
  getConnections() {
    return this.api.securedGet(this.api.getEndpoint('connections'));
  }
}
