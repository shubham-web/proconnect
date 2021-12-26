import { Location } from '@angular/common';
import { Component, Input, OnInit } from '@angular/core';

@Component({
  selector: 'app-sectionheader',
  templateUrl: './sectionheader.component.html',
  styleUrls: ['./sectionheader.component.css'],
})
export class SectionheaderComponent implements OnInit {
  @Input('title') title: string = '';
  constructor(private location: Location) {}
  goBack() {
    this.location.back();
  }
  getLabel() {}

  ngOnInit(): void {}
}
