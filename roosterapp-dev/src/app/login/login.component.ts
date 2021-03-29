import {Component, Optional, OnInit} from '@angular/core';
import { LoginService } from '../login.service';
import { Router } from '@angular/router';
import { Title } from '@angular/platform-browser';
import { HttpClient } from '@angular/common/http';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

  // Http client module inladen in constructor
  constructor(
    private loginService: LoginService,
    private router: Router,
    private title: Title
  ) {  }

  // Globale vars declareren
  response;
  errors;

  ngOnInit(): void {
    this.title.setTitle('RoosterApp - Inloggen');
  }

  // Methode die wordt aangeroepen als formulier wordt gepost door gebruiker
  onSubmit(formData): void {
    // Form input schrijven naar browser console
    console.log(formData);

    // Http POST request sturen naar API
    this.loginService.sendLoginForm(formData).subscribe(resp => {
      // Response body van API in var plaatsen
      this.response = resp.body;

      // Response van API naar console schrijven
      console.log(resp);

      // Gebruiker heeft correct ingelogd. Token & versleutelde username opslaan in localStorage
      localStorage.setItem('token', this.response.token);

      // Gebruiker omleiden naar beveiligde deel van applicatie
      this.router.navigate(['/portal']);
    },
      (error) => {
      console.log(error);

      this.errors = error;
      });
  }

}
