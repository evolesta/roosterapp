import { Component, OnInit } from '@angular/core';
import { AdminService } from '../admin.service';
import { faPencilAlt, faTrashAlt, faPlus } from '@fortawesome/free-solid-svg-icons';

@Component({
  selector: 'app-admin-user',
  templateUrl: './admin-user.component.html',
  styleUrls: ['./admin-user.component.css']
})
export class AdminUserComponent implements OnInit {

  constructor(
    private admin: AdminService
  ) { }

  // fa iconen
  faAdd = faPlus;
  faEdit = faPencilAlt;
  faTrash = faTrashAlt;

  // globale variabelen
  message;
  errors;
  users;
  teams;
  userData;
  assignedTeam;
  workHours;
  id;

  ngOnInit(): void {
    this.getUsers();
    this.getTeams();
  }

  // Pas het globale ID aan
  setId(id): void {
    this.id = id;
  }

  // Haal huidge gebruikers op uit DB
  getUsers(): void {
    this.admin.getUsers().subscribe(
      response => {
        console.log(response);
        this.users = response.body.data;
      }
    );
  }

  // Teams ophalen
  getTeams(): void {
    this.admin.getTeams().subscribe(
      response => {
        this.teams = response.body.teams;
      }
    );
  }

  // Specifieke gebruiker ophalen adhv ID
  getUserById(id): void {
    this.admin.getUserById(id).subscribe(
      response => {
        console.log(response);
        this.userData = response.body.userdata;
        this.assignedTeam = response.body.assigned_team;
        this.workHours = response.body.workhours;
      }
    );
  }

  // Voeg een nieuwe gebruiker toe aan de applicatie
  addUser(formdata): void {
    this.admin.addUser(formdata).subscribe(
      response => {
        console.log(response);
        this.message = response.body.message;
        this.getUsers();
      }, error => {
        console.log(error);
        this.errors = error.error;
      }
    );
  }

  // Bewerk een bestaande gebruiker
  editUser(formdata, id): void {
    this.admin.editUser(formdata, id).subscribe(
      response => {
        console.log(response);
        this.message = response.body.message;
        this.getUsers();
      }, error => {
        console.log(error);
        this.errors = error.error;
      }
    );
  }

}
