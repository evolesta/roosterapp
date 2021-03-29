import { Injectable } from '@angular/core';
import { apiurl } from './global-variable';
import {HttpClient, HttpHeaders} from '@angular/common/http';
import { BehaviorSubject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class RegisterService {

  constructor(
    public http: HttpClient
    ) { }

  // Specifieke API ophalen en maken
  API_URL = apiurl + '/reg';

  // Specifieke registratie ophalen voor portal form
  getRegistration(curDate): any {
    // GET request naar API sturen met huidige datum parameter
    return this.http.get(this.API_URL + '/getReg/' + curDate, { observe: 'response' });
  }

  // Registratie ophalen voor bewerk form
  getRegistrationById(id): any {
    // GET request voor het ophalen van een reg via ID
    return this.http.get(this.API_URL + '/getRegById/' + id, { observe: 'response' });
  }

  // Bewerkte registratie opsturen - via bewerk form
  editRegistrationById(data, id): any {
    return this.http.post(this.API_URL + '/editRegById/' + id, data, { observe: 'response' });
  }

  // Registratie verwijderen middels ID
  deleteRegistrationById(id): any {
    return this.http.delete(this.API_URL + '/deleteRegById/' + id , { observe: 'response' });
  }

  // Alle registraties van gebruiker ophalen
  getRegistrations(): any {
    return this.http.get(this.API_URL + '/getRegs', { observe: 'response' });
  }

  // Nieuwe registratie toevoegen aan database - via portal form
  addRegistration(data): any {
    return this.http.post(this.API_URL + '/addReg', data, { observe: 'response' });
  }

  // Bestaande registratie wijzigen in database - via portal form
  editRegistration(data): any {
    return this.http.post(this.API_URL + '/editReg', data, { observe: 'response' });
  }

  // Bulk registratie naar back-end sturen via POST request
  addBulkRegistrations(array): any {
    return this.http.post(this.API_URL + '/addBulkRegs', array, { observe: 'response' });
  }

  // Methode die de saldo informatie ophaalt van de gebruiker
  getSaldo(): any {
    return this.http.get(apiurl + '/saldo/getSaldo', { observe: 'response' });
  }

  // POST methode die gebruiker uren op laat nemen
  urenOpnemen(formdata): any {
    return this.http.post(this.API_URL + '/urenOpnemen', formdata, { observe: 'response' });
  }
}
