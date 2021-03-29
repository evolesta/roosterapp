import { TestBed } from '@angular/core/testing';

import { VerlofService } from './verlof.service';

describe('VerlofService', () => {
  let service: VerlofService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(VerlofService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
