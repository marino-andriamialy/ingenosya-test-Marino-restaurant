import { TestBed } from '@angular/core/testing';

import { RepaService } from './repa.service';

describe('RepasService', () => {
  let service: RepaService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(RepaService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
