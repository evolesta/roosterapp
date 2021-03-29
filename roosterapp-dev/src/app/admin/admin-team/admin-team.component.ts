import { Component, OnInit } from '@angular/core';
import { AdminService } from '../admin.service';
import { faPlus, faPencilAlt, faTrashAlt, faUsers } from '@fortawesome/free-solid-svg-icons';

@Component({
  selector: 'app-admin-team',
  templateUrl: './admin-team.component.html',
  styleUrls: ['./admin-team.component.css']
})
export class AdminTeamComponent implements OnInit {

  constructor(
    private admin: AdminService
  ) { }

  // FA iconen
  faAdd = faPlus;
  faTrash = faTrashAlt;
  faEdit = faPencilAlt;
  faGroup = faUsers;

  // globale variabelen
  teams;
  managers;
  teaminfo;
  sectors;
  teammembers;
  id;
  message;
  errors;

  ngOnInit(): void {
    this.getTeams();
  }

  setId(id): void {
    this.id = id;
  }

  // Alle teams ophalen
  getTeams(): void {
    this.admin.getTeams().subscribe(
      response => {
        console.log(response);
        this.teams = response.body.teams;
        this.managers = response.body.managers;
        this.sectors = response.body.sectors;
      });
  }

  // Informatie over een specifiek team ophalen adhv ID
  getTeamById(id): void {
    this.admin.getTeamById(id).subscribe(
      response => {
        console.log(response);
        this.teaminfo = response.body.data;
        this.id = response.body.data.id;
      }
    );
  }

  // Teamleden van een team ophalen
  getTeamMembers(teamId): void {
    this.admin.getTeamMembers(teamId).subscribe(
      response => {
        console.log(response);
        this.teammembers = response.body;
      }
    );
  }

  // Nieuw team toevoegen
  addTeam(formdata): void {
    this.admin.addTeam(formdata).subscribe(
      response => {
        console.log(response);
        this.message = response.body.message;
        this.getTeams();
      }, error => {
        console.log(error);
        this.errors = error.error;
      }
    );
  }

  // Bestaand team bewerken met nieuwe data
  editTeam(formdata): void {
    this.admin.editTeam(formdata, this.id).subscribe(
      response => {
        console.log(response);
        this.message = response.body.message;
        this.getTeams();
      }, error => {
        console.log(error);
        this.errors = error.error;
      }
    );
  }

  // Team verwijderen
  deleteTeam(): void {
    this.admin.deleteTeam(this.id).subscribe(
      response => {
        console.log(response);
        this.message = response.body.message;
        this.getTeams();
      }
    );
  }

}
