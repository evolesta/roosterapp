import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PortalStartregComponent } from './portal-startreg.component';

describe('PortalStartregComponent', () => {
  let component: PortalStartregComponent;
  let fixture: ComponentFixture<PortalStartregComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ PortalStartregComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(PortalStartregComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
