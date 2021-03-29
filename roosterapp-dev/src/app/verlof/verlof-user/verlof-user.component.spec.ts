import { ComponentFixture, TestBed } from '@angular/core/testing';

import { VerlofUserComponent } from './verlof-user.component';

describe('VerlofUserComponent', () => {
  let component: VerlofUserComponent;
  let fixture: ComponentFixture<VerlofUserComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ VerlofUserComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(VerlofUserComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
