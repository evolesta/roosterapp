import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PortalAllregComponent } from './portal-allreg.component';

describe('PortalAllregComponent', () => {
  let component: PortalAllregComponent;
  let fixture: ComponentFixture<PortalAllregComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ PortalAllregComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(PortalAllregComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
