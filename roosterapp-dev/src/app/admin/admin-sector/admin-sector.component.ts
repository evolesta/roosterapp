import { Component, OnInit } from '@angular/core';
import { AdminService } from '../admin.service';
import { faEdit, faTrashAlt, faPlus } from '@fortawesome/free-solid-svg-icons';

@Component({
  selector: 'app-admin-sector',
  templateUrl: './admin-sector.component.html',
  styleUrls: ['./admin-sector.component.css']
})
export class AdminSectorComponent implements OnInit {

  constructor(
    private admin: AdminService
  ) { }

  // Font awesome iconen
  faAdd = faPlus;
  faEdit = faEdit;
  faTrash = faTrashAlt;

  // Globale variabelen
  sectorData;
  sector;
  id;
  message;
  errors;

  ngOnInit(): void {
    this.getSector();
  }

  // TABBLAD - SECTORBEHEER
  setId(id): void {
    this.id = id;
  }

  // Alle sectoren ophalen uit DB
  getSector(): void {
    this.admin.getSector().subscribe(
      response => {
        this.sectorData = response.body.data;
      }
    );
  }

  // Specifieke sector ophalen uit back-end bij het ID
  getSectorById(id): void {
    this.id = id;

    this.admin.getSectorById(this.id).subscribe(
      response => {
        console.log(response);
        this.sector = response.body.data;
      }
    );
  }

  // Nieuwe sector toevoegen aan DB
  addSector(formdata): void {
    this.admin.addSector(formdata).subscribe(
      response => {
        console.log(response);
        this.message = response.body.message;
        this.getSector();

      }, error => {
        console.log(error);
        this.errors = error.error;
      }
    );
  }

  // Sector bewerken adhv ID
  editSector(formdata): void {
    this.admin.editSector(formdata, this.id).subscribe(
      response => {
        console.log(response);
        this.message = response.body.message;
        this.getSector();

      }, error => {
        console.log(error);
        this.errors = error.error;
      }
    );
  }

  // Sector verwijderen adhv ID
  deleteSector(id): void {
    this.admin.deleteSector(id).subscribe(
      response => {
        console.log(response);
        this.message = response.body.message;
        this.getSector();
      }
    );
  }

}
