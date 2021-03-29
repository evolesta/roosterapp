import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { faCheck } from '@fortawesome/free-solid-svg-icons';
import { LoginService } from '../../login.service';

@Component({
  selector: 'app-activate-user',
  templateUrl: './activate-user.component.html',
  styleUrls: ['./activate-user.component.css']
})
export class ActivateUserComponent implements OnInit {

  constructor(
    private route: ActivatedRoute,
    private login: LoginService
  ) { }

  // font awesome iconen laden
  faCheck = faCheck;

  // Globale variabelen
  activationId;
  message;
  errors;

  ngOnInit(): void {
    // ID uitlezen uit URL
    this.activationId = this.route.snapshot.paramMap.get('id');
  }

  // Methode die wordt aangeroepen als het formulier gepost wordt
  submitForm(formdata): void {
    this.login.activateUser(formdata, this.activationId).subscribe(
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
