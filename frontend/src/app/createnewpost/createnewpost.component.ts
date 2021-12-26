import { Component, OnInit } from '@angular/core';
import { ApiService } from '../api.service';
import { PostsService } from '../posts.service';

@Component({
  selector: 'app-createnewpost',
  templateUrl: './createnewpost.component.html',
  styleUrls: ['./createnewpost.component.css'],
})
export class CreatenewpostComponent implements OnInit {
  posting = false;
  text = '';
  media = {
    images: [],
    video: [],
  };
  constructor(private postService: PostsService, private api: ApiService) {}

  ngOnInit(): void {}
  async publishPost() {
    this.posting = true;
    let images = [];
    if (this.media.images.length > 0) {
      for (let image of this.media.images) {
        let response: any = await this.api
          .upload(image, 'posts')
          .catch(console.log);
        if (response) {
          let url = response.data[0]?.path;
          images.push({ url });
        }
      }
    }
    this.media.images = images;
    if (images.length === 0 && this.media.video.length > 0) {
      let videos = [];
      for (let video of this.media.video) {
        let response: any = await this.api
          .upload(video, 'posts')
          .catch(console.log);
        if (response) {
          let url = response.data[0]?.path;
          videos.push({ url });
        }
      }
      this.media.video = videos;
    }
    this.postService
      .publishNewPost({
        text: this.text,
        media: this.media,
      })
      .then(() => {
        this.text = '';
        this.clearMedia();
        this.posting = false;
        this.postService.newPostAdded.emit();
      })
      .catch(console.log);
  }
  addMedia(type: 'images' | 'video') {
    let input = document.createElement('input');
    input.type = 'file';
    input.multiple = true;
    input.accept = type === 'images' ? 'image/*' : 'video/mp4';
    input.addEventListener('change', () => {
      let files = input.files;
      this.media[type] = Array.from(files);
      console.log(this.media);
    });
    input.click();
  }
  clearMedia() {
    this.media.video = this.media.images = [];
  }
}
