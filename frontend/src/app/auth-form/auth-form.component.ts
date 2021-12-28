import { Component, Input, OnInit } from '@angular/core';

@Component({
  selector: 'app-auth-form',
  templateUrl: './auth-form.component.html',
  styleUrls: ['./auth-form.component.css'],
})
export class AuthFormComponent implements OnInit {
  @Input('loading') loading: boolean = false;
  constructor() {}

  ngOnInit(): void {}
}
