import { Component, OnInit } from '@angular/core';
import { VerlofService } from '../verlof.service';
import { Title } from '@angular/platform-browser';
import { faPlus, faPencilAlt, faArrowRight, faTrashAlt } from '@fortawesome/free-solid-svg-icons';

@Component({
  selector: 'app-verlof-user',
  templateUrl: './verlof-user.component.html',
  styleUrls: ['./verlof-user.component.css']
})
export class VerlofUserComponent implements OnInit {

  constructor(
    private title: Title,
    private verlof: VerlofService
  ) { }

  // Globale variabelen
  verlofData;
  verlofSingleData;
  message;
  errors;
  id;

  // fa iconen
  faPlus = faPlus;
  faEdit = faPencilAlt;
  faIndienen = faArrowRight;
  faDelete = faTrashAlt;

  ngOnInit(): void {
    this.getVerlof();
    this.title.setTitle('RoosterApp - Verlof');
  }

  setId(id): void {
    this.id = id;
  }

  // Verlof registraties ophalen
  getVerlof(): void {
    this.verlof.getVerlof().subscribe(
      response => {
        console.log(response);
        this.verlofData = response.body.data;
      }
    );
  }

  // Bestaande opvraag ophalen
  getVerlofById(id): void {
    this.verlof.getVerlofById(id).subscribe(
      response => {
        console.log(response);
        this.verlofSingleData = response.body.data;
        this.id = id;
      });
  }

  // nieuwe aanvraag indienen
  addNieuweAanvraag(formdata): void {
    this.verlof.addVerlof(formdata).subscribe(
      response => {
        console.log(response);
        this.message = response.body.message;
        this.getVerlof();
      }, error => {
        console.log(error);
        this.errors = error.error;
      }
    );
  }

  // aanvraag indienen voor manager
  aanvraagIndienen(id): void {
    this.verlof.indienenVerlof(id).subscribe(
      response => {
        console.log(response);
        this.message = response.body.message;
        this.getVerlof();
      }
    );
  }

  // bestaande aanvraag bewerken
  editAanvraag(formdata): void {
    this.verlof.editVerlofById(formdata, this.id).subscribe(
      response => {
        console.log(response);
        this.message = response.body.message;
        this.getVerlof();
      }, error => {
        console.log(error);
        this.errors = error.error;
      }
    );
  }

  // aanvraag verwijderen
  deleteAanvraag(): void {
    this.verlof.deleteVerlof(this.id).subscribe(
      response => {
        console.log(response);
        this.message = response.body.message;
        this.getVerlof();
      }
    );
  }

}
