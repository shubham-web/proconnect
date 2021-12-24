import { Component, OnInit, OnDestroy } from '@angular/core';
import { AuthService } from './auth.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css'],
})
export class AppComponent implements OnInit {
  public userCheckDone: boolean = false;
  constructor(private auth: AuthService) {}
  ngOnInit() {
    this.auth.userCheck().finally(() => {
      this.userCheckDone = true;
    });
  }
}
