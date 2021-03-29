import { Component, Input } from '@angular/core';
import { faStop, faPlay, faCalendar } from '@fortawesome/free-solid-svg-icons';

@Component({
  selector: 'app-portal-allreg',
  templateUrl: './portal-allreg.component.html',
  styleUrls: ['./portal-allreg.component.css']
})
export class PortalAllregComponent {

  constructor() { }

  @Input() respdata;

  start = faPlay;
  stop = faStop;
  calendar = faCalendar;

}
