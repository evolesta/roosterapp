import { Component, OnInit } from '@angular/core';
import { faEnvelope } from '@fortawesome/free-solid-svg-icons';
import { LoginService } from '../../login.service';

@Component({
  selector: 'app-reset-password',
  templateUrl: './reset-password.component.html',
  styleUrls: ['./reset-password.component.css']
})
export class ResetPasswordComponent implements OnInit {

  constructor(
    private login: LoginService
  ) { }

  // font awesome iconen
  faEnvelope = faEnvelope;

  // Globale variablelen
  message;
  errors;

  ngOnInit(): void {
  }

  sendForm(formdata): void {
    this.login.resetPassword(formdata).subscribe(
      response => {
        console.log(response);
        this.message = response.body.message;
      }, error => {
        console.log(error);
        this.errors = error.error;
      }
    );
  }

}
