import { NgModule } from '@angular/core';
import { Routes, RouterModule, CanActivate } from '@angular/router';
import { PortalComponent } from './portal/portal.component';
import { LoginComponent } from './login/login.component';
import { BulkComponent } from './bulk/bulk.component';
import { SettingsComponent } from './settings/settings.component';
import { LogoutComponent } from './logout/logout.component';
import { AuthGuard } from './auth/auth.guard';
import { EditRegistrationComponent } from './edit-registration/edit-registration.component';
import {AuthorizationGuard} from './auth/authorization.guard';
import {ActivateUserComponent} from './auth/activate-user/activate-user.component';
import {AdminUserComponent} from './admin/admin-user/admin-user.component';
import {AdminSectorComponent} from './admin/admin-sector/admin-sector.component';
import {AdminTeamComponent} from './admin/admin-team/admin-team.component';
import {ManagerInsightsComponent} from './manager/manager-insights/manager-insights.component';
import { ResetPasswordComponent } from './login/reset-password/reset-password.component';
import { SetPasswordComponent } from './login/set-password/set-password.component';
import {VerlofUserComponent} from "./verlof/verlof-user/verlof-user.component";
import {VerlofManagerComponent} from "./manager/verlof-manager/verlof-manager.component";

// Front-end routes. Routes met canActivate zijn beveiligd met een guard
const routes: Routes = [
  // Login / auth gebasseerde routes
  { path: '', component: LoginComponent},
  { path: 'logout', component: LogoutComponent },
  { path: 'activateUser/:id', component: ActivateUserComponent },
  { path: 'reset-password', component: ResetPasswordComponent },
  { path: 'set-password/:id', component: SetPasswordComponent },

  // URLs voor registraties
  { path: 'portal', component: PortalComponent, canActivate: [AuthGuard] },
  { path: 'bulk', component: BulkComponent, canActivate: [AuthGuard] },
  { path: 'editreg/:id', component: EditRegistrationComponent, canActivate: [AuthGuard] },

  // URLs voor instellingen
  { path: 'settings', component: SettingsComponent, canActivate: [AuthGuard] },

  // Manager routes met authorisatie guard
  {
    path: 'manager-insights',
    component: ManagerInsightsComponent,
    canActivate: [AuthGuard, AuthorizationGuard],
    data: {roles: ['admin', 'manager']}
  },
  {
    path: 'manager-verlof',
    component: VerlofManagerComponent,
    canActivate: [AuthGuard, AuthorizationGuard],
    data: {roles: ['admin', 'manager']}
  },

  // Verlof routes
  { path: 'verlof-user', component: VerlofUserComponent, canActivate: [AuthGuard] },

  // Beheerder routes met authorisatie guard
  { path: 'admin-user',
    component: AdminUserComponent,
    canActivate: [AuthGuard, AuthorizationGuard],
    data: {roles: ['admin']}
  },
  { path: 'admin-team',
    component: AdminTeamComponent,
    canActivate: [AuthGuard, AuthorizationGuard],
    data: {roles: ['admin']}
  },
  { path: 'admin-sector',
    component: AdminSectorComponent,
    canActivate: [AuthGuard, AuthorizationGuard],
    data: {roles: ['admin']}
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule],
  providers: [AuthGuard, AuthorizationGuard],
})
export class AppRoutingModule { }
