import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { PortalComponent } from './portal/portal.component';

import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import { HttpClientModule, HTTP_INTERCEPTORS } from '@angular/common/http';
import { LoginComponent } from './login/login.component';
import { HeaderComponent } from './header/header.component';
import { FooterComponent } from './footer/footer.component';
import { FontAwesomeModule } from '@fortawesome/angular-fontawesome';
import {DatePipe} from '@angular/common';
import { PortalNoregformComponent } from './portal-noregform/portal-noregform.component';
import { PortalAllregComponent } from './portal-allreg/portal-allreg.component';
import { PortalStartregComponent } from './portal-startreg/portal-startreg.component';
import { BulkComponent } from './bulk/bulk.component';
import { NgxTimerModule } from 'ngx-timer';
import { SettingsComponent } from './settings/settings.component';
import { LogoutComponent } from './logout/logout.component';
import { EditRegistrationComponent } from './edit-registration/edit-registration.component';
import { ActivateUserComponent } from './auth/activate-user/activate-user.component';
import { AdminUserComponent } from './admin/admin-user/admin-user.component';
import { AdminTeamComponent } from './admin/admin-team/admin-team.component';
import { AdminSectorComponent } from './admin/admin-sector/admin-sector.component';
import {AuthorizationInterceptor} from "./authorization.interceptor";
import { ManagerInsightsComponent } from './manager/manager-insights/manager-insights.component';
import { ResetPasswordComponent } from './login/reset-password/reset-password.component';
import { SetPasswordComponent } from './login/set-password/set-password.component';
import { VerlofUserComponent } from './verlof/verlof-user/verlof-user.component';
import { VerlofManagerComponent } from './manager/verlof-manager/verlof-manager.component';

@NgModule({
  declarations: [
    AppComponent,
    PortalComponent,
    LoginComponent,
    HeaderComponent,
    FooterComponent,
    PortalNoregformComponent,
    PortalAllregComponent,
    PortalStartregComponent,
    BulkComponent,
    SettingsComponent,
    LogoutComponent,
    EditRegistrationComponent,
    ActivateUserComponent,
    AdminUserComponent,
    AdminTeamComponent,
    AdminSectorComponent,
    ManagerInsightsComponent,
    ResetPasswordComponent,
    SetPasswordComponent,
    VerlofUserComponent,
    VerlofManagerComponent,
  ],
    imports: [
        BrowserModule,
        AppRoutingModule,
        FormsModule,
        FontAwesomeModule,
        NgxTimerModule,
        ReactiveFormsModule,
        HttpClientModule,
    ],
  providers: [
    DatePipe,
    {
      provide: HTTP_INTERCEPTORS,
      useClass: AuthorizationInterceptor,
      multi: true
    }
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
