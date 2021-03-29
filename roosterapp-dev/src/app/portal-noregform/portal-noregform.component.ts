import { Component, Output, EventEmitter } from '@angular/core';
import { faPlay } from '@fortawesome/free-solid-svg-icons';
import { DatePipe } from '@angular/common';
import { RegisterService } from '../register.service';

@Component({
  selector: 'app-portal-noregform',
  templateUrl: './portal-noregform.component.html',
  styleUrls: ['./portal-noregform.component.css']
})
export class PortalNoregformComponent {

  constructor(
    private datepipe: DatePipe,
    private register: RegisterService,
  ) { }

  // Nieuwe eventmitter aanmaken om de data in de parent te verversen als de form gepost is
  @Output() formEvent = new EventEmitter<boolean>();

  // dit formulier wordt als child getoont in comp. portal, als er op de datum GEEN registratie is

  faPlay = faPlay;
  curDate = this.datepipe.transform(new Date(), 'yyyy-MM-dd');
  curTime = this.datepipe.transform(new Date(), 'HH:mm');
  errors;

  // Registratie form naar API sturen
  onSubmit(data): void {
    this.register.addRegistration(data).subscribe(resp => {

      // Toevoegen is succesvol
      console.log(resp);

      // Parent component bijwerken met de nieuwe informatie
      this.formEvent.emit(true);

    }, error => {
      // Er is een fout opgetreden, deze tonen aan gebruiker
      console.log(error);
      this.errors = error.error;
    });
  }

}
