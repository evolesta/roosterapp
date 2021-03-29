import { Component, OnInit } from '@angular/core';
import { ManagerService } from '../manager.service';
import { Title } from '@angular/platform-browser';
import { faUserTie } from '@fortawesome/free-solid-svg-icons';

@Component({
  selector: 'app-manager-insights',
  templateUrl: './manager-insights.component.html',
  styleUrls: ['./manager-insights.component.css']
})
export class ManagerInsightsComponent implements OnInit {

  constructor(
    private manager: ManagerService,
    private title: Title
  ) { }

  // Globale variabelen
  teams;
  teamMembers;

  // Font awesome
  faUserTie = faUserTie;

  ngOnInit(): void {
    this.title.setTitle('RoosterApp - Manager Portaal');

    // Teams ophalen van manager
    this.getTeamsInsights();
  }

  getTeamsInsights(): void {
    this.manager.getTeamsIngishts().subscribe(
      response => {
        console.log(response);
        this.teams = response.body.teams;
        this.teamMembers = response.body.team_members;
      }
    );
  }

}
