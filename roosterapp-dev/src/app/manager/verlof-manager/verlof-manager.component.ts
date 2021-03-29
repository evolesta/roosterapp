import { Component, OnInit } from '@angular/core';
import { ManagerService } from '../manager.service';
import { faCheck, faTimes } from '@fortawesome/free-solid-svg-icons';

@Component({
  selector: 'app-verlof-manager',
  templateUrl: './verlof-manager.component.html',
  styleUrls: ['./verlof-manager.component.css']
})
export class VerlofManagerComponent implements OnInit {

  constructor(
    private manager: ManagerService
  ) { }

  // Globale variabelen
  newVerlofRequests;
  verloffen;
  message;
  errors;

  faCheck = faCheck;
  faCross = faTimes;

  ngOnInit(): void {
    // Verlof aanvragen ophalen
    this.getNewVerlofRequests();
    this.getVerlof();
  }

  getNewVerlofRequests(): void {
    this.manager.getNewVerlofRequests().subscribe(
      response => {
        console.log(response);
        this.newVerlofRequests = response.body;
      }
    );
  }

  getVerlof(): void {
    this.manager.getVerlof().subscribe(
      response => {
        console.log(response);
        this.verloffen = response.body;
      }
    );
  }

  acceptRequest(id): void {
    this.manager.acceptVerlofRequest(id).subscribe(
      response => {
        console.log(response);
        this.getNewVerlofRequests();
        this.getVerlof();
      }, error => {
        console.log(error);
        this.errors = error.error;
      }
    );
  }

  denyRequest(id): void {
    this.manager.denyVerlofRequest(id).subscribe(
      response => {
        console.log(response);
        this.getNewVerlofRequests();
        this.getVerlof();
      }, error => {
        console.log(error);
        this.errors = error.error;
      }
    );
  }

}
