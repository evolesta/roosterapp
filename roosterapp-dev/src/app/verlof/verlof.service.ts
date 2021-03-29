import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { apiurl } from '../global-variable';

@Injectable({
  providedIn: 'root'
})
export class VerlofService {

  constructor(
    private http: HttpClient
  ) { }

  // Globale variabelen
  API_URL = apiurl + '/verlof';

  // GET request voor het ophalen van de verlofgegevens
  getVerlof(): any {
    return this.http.get(this.API_URL + '/getVerlof', { observe: 'response'});
  }

  // GET request voor het ophalen van een specifiek verlof adhv ID
  getVerlofById(id): any {
    return this.http.get(this.API_URL + '/getVerlofById/' + id, { observe: 'response' });
  }

  // POST request voor het indienen van een nieuwe aanvraag
  addVerlof(formdata): any {
    return this.http.post(this.API_URL + '/addVerlof', formdata, { observe: 'response' });
  }

  // GET request voor het indienen van een aanvraag
  indienenVerlof(id): any {
    return this.http.get(this.API_URL + '/indienenVerlof/' + id, { observe: 'response' });
  }

  // POST request voor het bewerken van een bestaande aanvraag
  editVerlofById(formdata, id): any {
    return this.http.post(this.API_URL + '/editVerlofById/' + id, formdata, { observe: 'response'});
  }

  // DELETE request voor het verwijderen van een aanvraag
  deleteVerlof(id): any {
    return this.http.delete(this.API_URL + '/deleteVerlof/' + id, { observe: 'response' });
  }
}
