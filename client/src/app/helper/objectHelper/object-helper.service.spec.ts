import { TestBed, inject } from '@angular/core/testing';

import { ObjectHelperService } from './object-helper.service';

describe('ObjectHelperService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [ObjectHelperService]
    });
  });

  it('should be created', inject([ObjectHelperService], (service: ObjectHelperService) => {
    expect(service).toBeTruthy();
  }));
});
