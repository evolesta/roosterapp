import { Injectable } from '@angular/core';
import { apiurl } from '../global-variable';
import {HttpClient} from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class AdminService {

  constructor(
    private http: HttpClient
  ) { }

  // API url definieren
  API_URL = apiurl + '/admin';

  // GET resut naar back-end sturen voor alle gebruikers
  getUsers(): any {
    return this.http.get(this.API_URL + '/getUsers', { observe: 'response' });
  }

  // GET request voor het ophalen van een specifieke gebruiker
  getUserById(id): any {
    return this.http.get(this.API_URL + '/getUserById/' + id, { observe: 'response' });
  }

  // POST request naar back-end sturen voor het toevoegen van een gebruiker
  addUser(formdata): any {
    return this.http.post(this.API_URL + '/addUser', formdata, { observe: 'response' });
  }

  // POST request naar back-end sturen voor het bewerken van een gebruiker
  editUser(formdata, id): any {
    return this.http.post(this.API_URL + '/editUser/' + id, formdata, { observe: 'response' });
  }

  // GET request naar back-end sturen om alle teams, managers op te halen
  getTeams(): any {
    return this.http.get(this.API_URL + '/getTeams', { observe: 'response' });
  }

  // GET request naar back-end sturen met specifieke informatie over het team
  getTeamById(id): any {
    return this.http.get(this.API_URL + '/getTeamById/' + id, { observe: 'response' });
  }

  // GET request naar back-end sturen om de teamleden op te halen
  getTeamMembers(id): any {
    return this.http.get(this.API_URL + '/getTeamMembers/' + id, { observe: 'response' });
  }

  // POST request naar back-end sturen om een nieuw team toe te voegen
  addTeam(formdata): any {
    return this.http.post(this.API_URL + '/addTeam', formdata, { observe: 'response' });
  }

  // POST request naar back-end sturen met gewijzigde form data
  editTeam(formdata, id): any {
    return this.http.post(this.API_URL + '/editTeam/' + id, formdata, { observe: 'response' });
  }

  // DELETE request naar back-end sturen om team te verwijderen
  deleteTeam(id): any {
    return this.http.delete(this.API_URL + '/deleteTeam/' + id, { observe: 'response' });
  }

  // GET request voor ophalen sectoren uit back-end
  getSector(): any {
    return this.http.get(this.API_URL + '/getSector', { observe: 'response' });
  }

  // GET request voor ophalen sector informatie uit back-end
  getSectorById(id): any {
    return this.http.get(this.API_URL + '/getSectorById/' + id, { observe: 'response' });
  }

  // POST request voor toevoegen sector naar back-end sturen
  addSector(formdata): any {
    return this.http.post(this.API_URL + '/addSector', formdata, { observe: 'response' });
  }

  // POST request voor het bewerken van een sector naar back-end sturen
  editSector(formdata, id): any {
    return this.http.post(this.API_URL + '/editSector/' + id, formdata, { observe: 'response' });
  }

  // DELETE request naar back-end sturen voor het verwijderen van een sector
  deleteSector(id): any {
    return this.http.delete(this.API_URL + '/deleteSector/' + id, { observe: 'response' });
  }
}
