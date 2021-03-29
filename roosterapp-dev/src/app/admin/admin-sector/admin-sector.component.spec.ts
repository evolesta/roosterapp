import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AdminSectorComponent } from './admin-sector.component';

describe('AdminSectorComponent', () => {
  let component: AdminSectorComponent;
  let fixture: ComponentFixture<AdminSectorComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ AdminSectorComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(AdminSectorComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
