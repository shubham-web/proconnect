import { Component, Input, OnInit } from '@angular/core';

@Component({
  selector: 'app-logo',
  templateUrl: './logo.component.html',
  styleUrls: ['./logo.component.css'],
})
export class LogoComponent implements OnInit {
  @Input('link') link = '/';
  @Input('footer') footer = false;
  constructor() {}

  ngOnInit(): void {}
}
