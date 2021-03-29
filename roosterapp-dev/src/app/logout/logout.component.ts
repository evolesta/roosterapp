import { Component, OnInit } from '@angular/core';
import { LoginService } from '../login.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-logout',
  templateUrl: './logout.component.html',
  styleUrls: ['./logout.component.css']
})
export class LogoutComponent implements OnInit {

  constructor(
    private login: LoginService,
    private router: Router) { }

  ngOnInit(): void {
    this.login.logout();
    this.router.navigateByUrl('/');
  }

}
