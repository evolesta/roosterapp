import { Injectable } from '@angular/core';
import {HttpClient, HttpHeaders} from '@angular/common/http';
import {observable, Observable} from 'rxjs';
import { Router } from '@angular/router';
import { apiurl } from './global-variable';

@Injectable({
  providedIn: 'root'
})
export class LoginService {
  // API url definieren
  private REST_API_URL = apiurl + '/auth';

  // Http client inladen via de constructor
  constructor(
    private http: HttpClient,
    private router: Router
    ) { }

  // Methode die een POST request stuurt naar de back-end
  sendLoginForm(data): Observable<any> {
    return this.http.post(this.REST_API_URL + '/login', data, { observe: 'response' });
  }

  // Methode om gebruiker uit loggen uit de applicatie
  logout(): void {
    // cookies verwijderen
    localStorage.removeItem('token');

    // Gebruiker omleiden naar login pagina
    this.router.navigateByUrl('/login');
  }

  // POST request naar back-end sturen om gebruiker te activeren
  activateUser(formdata, id): any {
    return this.http.post(this.REST_API_URL + '/activateUser/' + id, formdata, { observe: 'response' } );
  }

  // POST request voor het resetten van een wachtwoord
  resetPassword(formdata): any {
    return this.http.post(this.REST_API_URL + '/resetPassword', formdata, { observe: 'response' });
  }

  // POST request voor het instellen van het nieuwe wachtwoord
  setPassword(formdata, id): any {
    return this.http.post(this.REST_API_URL + '/setPassword/' + id, formdata, { observe: 'response' });
  }
}
