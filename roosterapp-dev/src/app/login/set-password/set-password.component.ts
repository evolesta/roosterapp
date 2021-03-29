import { Component, OnInit } from '@angular/core';
import { faSave } from '@fortawesome/free-solid-svg-icons';
import { ActivatedRoute } from '@angular/router';
import { LoginService } from '../../login.service';

@Component({
  selector: 'app-set-password',
  templateUrl: './set-password.component.html',
  styleUrls: ['./set-password.component.css']
})
export class SetPasswordComponent implements OnInit {

  constructor(
    private route: ActivatedRoute,
    private login: LoginService
  ) { }

  // font awesome iconen
  faSave = faSave;

  // Globale variablelen
  id;
  message;
  errors;

  ngOnInit(): void {
    // unieke ID uit url halen
    this.id = this.route.snapshot.paramMap.get('id');
  }

  sendForm(formdata): void {
    this.login.setPassword(formdata, this.id).subscribe(
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
