import { Injectable } from '@angular/core';
import { JwtHelperService } from '@auth0/angular-jwt';
import {HttpClient, HttpHeaders, HttpResponse } from '@angular/common/http';
import { apiurl } from '../global-variable';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  constructor(
    private http: HttpClient
  ) { }

  // API url definieren
  API_URL = apiurl + '/auth';

  // Token toevoegen aan HTTP requests
  options = {
    headers: new HttpHeaders({
      'Content-Type': 'application/json',
      token: localStorage.getItem('token')
    }),
    observe: 'response'
  };

  // Controleren of jwt token verlopen is
  // Als deze verlopen is, is er geen toegang meer tot de front-end en back-end
  public isAuthenticated(): boolean {
    // Token uit browser localstorage halen
    const token = localStorage.getItem('token');

    // Controleren of token nog geldig is, boolean teruggeven aan guard
    const jwt = new JwtHelperService();
    return !jwt.isTokenExpired(token);
  }

  // Controleren of gebruiker een juiste rol heeft
  // Op basis van de parameter een boolean teruggeven
  public getUserRole(): any {
    // Rol ophalen bij back-end
    // @ts-ignore
    return this.http.get(this.API_URL + '/getRole', this.options);
  }
}
