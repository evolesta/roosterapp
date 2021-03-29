import { Component, OnInit } from '@angular/core';
import { faSave } from '@fortawesome/free-solid-svg-icons';
import { SettingsService } from '../settings.service';
import { LoginService } from '../login.service';
import { Router } from '@angular/router';
import {Title} from '@angular/platform-browser';

@Component({
  selector: 'app-settings',
  templateUrl: './settings.component.html',
  styleUrls: ['./settings.component.css'],
})
export class SettingsComponent implements OnInit {

  constructor(
    private settings: SettingsService,
    private login: LoginService,
    private router: Router,
    private title: Title
  ) { }

  faSave = faSave;
  errors;
  message;
  userinfo;

  ngOnInit(): void {
    this.title.setTitle('RoosterApp - Instellingen');

    // Huidige gebruikersinfo ophalen
    this.settings.getUserinfo().subscribe(resp => {
      console.log(resp);
      this.userinfo = resp.body;
    });
  }

  // Nieuwe gebruikersgegevens sturen richting back-end
  submitUserinfo(formdata): void {
    this.settings.setUserinfo(formdata).subscribe(resp => {

      console.log(resp);
      this.message = resp.body.message;

    }, error => {

      console.log(error);
      this.errors = error.error;

    });
  }

  // Nieuwe werkuren sturen richting back-end
  submitWorkhours(formdata): void {
    this.settings.setWorkhours(formdata).subscribe(resp => {

      console.log(resp);
      this.message = resp.body.message;

    }, error => {

      console.log(error);
      this.errors = error.error;
    });
  }

  // Boolean sturen naar back-end
  submitEmailnotification(formdata): void {
    this.settings.setEmailnotification(formdata).subscribe(resp => {

      console.log(resp);
      this.message = resp.body.message;

    }, error => {

      console.log(error);
      this.errors = error.error;

    });
  }

}
