import { Component, OnInit } from '@angular/core';
import { faPlus, faTrashAlt, faTimesCircle } from '@fortawesome/free-solid-svg-icons';
import { RegisterService } from '../register.service';
import { ActivatedRoute } from '@angular/router';
import { Title } from '@angular/platform-browser';

@Component({
  selector: 'app-edit-registration',
  templateUrl: './edit-registration.component.html',
  styleUrls: ['./edit-registration.component.css']
})
export class EditRegistrationComponent implements OnInit {

  constructor(
    private register: RegisterService,
    private acroute: ActivatedRoute,
    private title: Title
  ) { }

  // Font awesome iconen laden
  faPlus = faPlus;
  faTrash = faTrashAlt;
  faCancel = faTimesCircle;

  // Response data
  regdata;
  errors;
  message;

  ngOnInit(): void {
    this.title.setTitle('RoosterApp - Bewerk registratie');

    // Gegevens ophalen van DB op basis van URL id
    this.acroute.params.subscribe(parameter => {
      this.register.getRegistrationById(parameter.id).subscribe(resp => {
        // Data verwerken
        console.log(resp);
        this.regdata = resp.body;
      });
    });
  }

  // Formulier als request naar back-end sturen
  submitForm(formdata): void {
    console.log(formdata);
    this.register.editRegistrationById(formdata, this.regdata.id).subscribe(response => {

      console.log(response);
      this.message = response.body.message;
    }, error => {

      console.log(error);
      this.errors = error;
    });
  }

  // Verwijder request naar back-end sturen voor verwijderen van registratie.
  deleteReg(): void {
    this.register.deleteRegistrationById(this.regdata.id).subscribe(response => {
      console.log(response);
      this.message = response.body.message;
    }, error => {
      console.log(error);
      this.errors = error;
    });
  }

}
