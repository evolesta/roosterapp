import { ComponentFixture, TestBed } from '@angular/core/testing';

import { VerlofManagerComponent } from './verlof-manager.component';

describe('VerlofManagerComponent', () => {
  let component: VerlofManagerComponent;
  let fixture: ComponentFixture<VerlofManagerComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ VerlofManagerComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(VerlofManagerComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
