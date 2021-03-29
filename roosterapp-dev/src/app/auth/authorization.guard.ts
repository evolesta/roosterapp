import { Injectable } from '@angular/core';
import { CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot } from '@angular/router';
import { Observable } from 'rxjs';
import { catchError, map } from 'rxjs/operators';
import { AuthService } from './auth.service';

@Injectable({
  providedIn: 'root'
})
export class AuthorizationGuard implements CanActivate {

  constructor(private auth: AuthService) {
  }

  userRole;

  canActivate(
    route: ActivatedRouteSnapshot,
    state: RouterStateSnapshot): Observable<boolean> {

    // Toegestane rol(len) ophalen uit route
    const allowedRoles = route.data.roles;

    // Rol van gebruiker uit back-end halen en controleren of deze rol toegestaan is
    return this.auth.getUserRole().pipe(map(response => {
      // @ts-ignore
      console.log(response.body.role);

      for (const role of allowedRoles) {
        // @ts-ignore
        if (role === response.body.role) {
          return true;
        }
      }
    }));
  }
}
