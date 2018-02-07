import { TestBed, inject } from '@angular/core/testing';

import { ArrayHelperService } from './array-helper.service';

describe('ArrayHelperService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [ArrayHelperService]
    });
  });

  it('should be created', inject([ArrayHelperService], (service: ArrayHelperService) => {
    expect(service).toBeTruthy();
  }));
});
