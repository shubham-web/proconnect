import { TestBed } from '@angular/core/testing';

import { BrowserstorageService } from './browserstorage.service';

describe('BrowserstorageService', () => {
  let service: BrowserstorageService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(BrowserstorageService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
