import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ManagerInsightsComponent } from './manager-insights.component';

describe('ManagerInsightsComponent', () => {
  let component: ManagerInsightsComponent;
  let fixture: ComponentFixture<ManagerInsightsComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ManagerInsightsComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ManagerInsightsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
