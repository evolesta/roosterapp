import { Injectable } from '@angular/core';
import {
  HttpRequest,
  HttpHandler,
  HttpEvent,
  HttpInterceptor
} from '@angular/common/http';
import { Observable } from 'rxjs';
import { JwtHelperService } from '@auth0/angular-jwt';

@Injectable()
export class AuthorizationInterceptor implements HttpInterceptor {

  constructor() {}

  intercept(request: HttpRequest<unknown>, next: HttpHandler): Observable<HttpEvent<any>> {
    // Controleren of token geldig is
    const jwt = new JwtHelperService();

    if (!jwt.isTokenExpired(localStorage.getItem('token'))) {
      // Token opvragen
      const token = localStorage.getItem('token');

      // Nieuwe headers opstellen
      const newRequest = request.clone({
        headers: request.headers.set('token', token)
      });

      return next.handle(newRequest);
    }
    else {
      return next.handle(request);
    }
  }
}
