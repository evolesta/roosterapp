import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { apiurl } from './global-variable';

@Injectable({
  providedIn: 'root'
})
export class SettingsService {

  constructor(
    private http: HttpClient
  ) { }

  // globale API URL aanmaken en bewerken
  API_URL = apiurl + '/settings';

  // Nieuwe headers aanmaken voor toegang tot beveiligde API
  options = {
    headers: new HttpHeaders({
      'Content-Type': 'application/json',
      token: localStorage.getItem('token')
    }),
    observe: 'response'
  };

  // GET request naar API sturen voor het ophalen van de huidige gebruikersdata (alles)
  getUserinfo(): any {
    // @ts-ignore
    return this.http.get(this.API_URL + '/getUserinfo', this.options);
  }

  // POST request naar API sturen voor aanpassen werkuren
  setWorkhours(data): any {
    // @ts-ignore
    return this.http.post(this.API_URL + '/setWorkhours', data, this.options);
  }

  // POST request naar API sturen voor aanpassen gebruikersgegevens
  setUserinfo(data): any {
    // @ts-ignore
    return this.http.post(this.API_URL + '/setUserinfo', data, this.options);
  }

  // POST request naar API sturen voor aanpassen e-mail instelling(en)
  setEmailnotification(data): any {
    // @ts-ignore
    return this.http.post(this.API_URL + '/setEmailnotification', data, this.options);
  }
}
