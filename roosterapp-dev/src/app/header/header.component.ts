import { Component, OnInit } from '@angular/core';
import { LoginService } from '../login.service';
import { faSignOutAlt, faClock } from '@fortawesome/free-solid-svg-icons';
import { AuthorizationGuard } from '../auth/authorization.guard';
import { JwtHelperService } from '@auth0/angular-jwt';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.css']
})
export class HeaderComponent implements OnInit {

  constructor(
    private login: LoginService,
    public AuthGuard: AuthorizationGuard,
    ) { }

    // Font awesome iconen declareren
  SignOutIcon = faSignOutAlt;
  faClock = faClock;

  // Gebruikersrol declareren
  userRole;

  // Gebruikers rol ophalen uit token

  ngOnInit(): void {
    // Gebruikersrol uit token uitlezen
    const jwt = new JwtHelperService();
    this.userRole = jwt.decodeToken(localStorage.getItem('token')).role;
  }

  doLogout(): void {
    this.login.logout();
}

}
