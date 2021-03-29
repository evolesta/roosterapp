import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PortalNoregformComponent } from './portal-noregform.component';

describe('PortalNoregformComponent', () => {
  let component: PortalNoregformComponent;
  let fixture: ComponentFixture<PortalNoregformComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ PortalNoregformComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(PortalNoregformComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
