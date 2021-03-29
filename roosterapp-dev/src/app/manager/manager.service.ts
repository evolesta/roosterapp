import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { apiurl } from '../global-variable';

@Injectable({
  providedIn: 'root'
})
export class ManagerService {

  constructor(
    private http: HttpClient
  ) { }

  API_URL = apiurl + '/manager';

  // GET request voor ophalen teams die bij manager horen
  getTeamsIngishts(): any {
    return this.http.get(this.API_URL + '/getTeamsInsights', { observe: 'response' });
  }

  // GET request voor ophalen verlofdata
  getNewVerlofRequests(): any {
    return this.http.get(this.API_URL + '/getVerlofRequests', { observe: 'response' });
  }

  // GET request voor ophalen verlofdata
  getVerlof(): any {
    return this.http.get(this.API_URL + '/getVerlof', { observe: 'response' });
  }

  // PUT request voor het accepteren van een verlofaanvraag
  acceptVerlofRequest(id): any {
    return this.http.post(this.API_URL + '/acceptVerlofRequest/' + id, { observe: 'response' });
  }

  // PUT request voor het weigeren van een verlofaanvraag
  denyVerlofRequest(id): any {
    return this.http.post(this.API_URL + '/denyVerlofRequest/' + id, { observe: 'response' });
  }
}
