import {Component, Input, Output, OnInit, EventEmitter} from '@angular/core';
import { DatePipe } from '@angular/common';
import { faStop } from '@fortawesome/free-solid-svg-icons/faStop';
import { RegisterService } from '../register.service';
import {CountupTimerService, countUpTimerConfigModel, timerTexts} from 'ngx-timer';

@Component({
  selector: 'app-portal-startreg',
  templateUrl: './portal-startreg.component.html',
  styleUrls: ['./portal-startreg.component.css']
})
export class PortalStartregComponent implements OnInit {

  constructor(
    private date: DatePipe,
    private register: RegisterService,
    private counter: CountupTimerService
  ) { }

  // Nieuwe eventmitter aanmaken om de data in de parent te verversen als de form gepost is
  @Output() formEvent = new EventEmitter<boolean>();

  // Dit formulier wordt gebruikt als de start registratie is ingevoerd, maar de stop registratie nog 0 is
  faStop = faStop;
  @Input() respdata;
  curTime = this.date.transform(new Date(), 'HH:mm');
  errors;
  testConfig;

  ngOnInit(): void {
    // Timer configureren
    this.testConfig = new countUpTimerConfigModel();
    this.testConfig.timerTexts = new timerTexts();
    this.testConfig.timerTexts.hourText = ':';
    this.testConfig.timerTexts.minuteText = ':';
    this.testConfig.timerTexts.secondsText = ' ';

    // Timer initieeren
    this.counter.startTimer(new Date(this.respdata.date + 'T' + this.respdata.start));
  }

  onSubmit(data): void {
    // POST request naar database sturen om de registratie verder in te vullen
    this.register.editRegistration(data).subscribe(resp => {

      // succes, response naar console schrijven
      console.log(resp);

      // Data in parent verversen door de EventMitter te activeren
      this.formEvent.emit(true);
    }, error => {

      // Error, foutmelding tonen aan ui
      console.log(error);
      this.errors = error;
    });
  }



}
