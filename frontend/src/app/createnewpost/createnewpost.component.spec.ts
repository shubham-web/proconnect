import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CreatenewpostComponent } from './createnewpost.component';

describe('CreatenewpostComponent', () => {
  let component: CreatenewpostComponent;
  let fixture: ComponentFixture<CreatenewpostComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ CreatenewpostComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(CreatenewpostComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
