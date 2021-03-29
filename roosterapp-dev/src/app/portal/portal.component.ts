import {Component, OnInit } from '@angular/core';
import { DatePipe } from '@angular/common';
import { RegisterService } from '../register.service';
import { SettingsService } from '../settings.service';
import { faStopwatch, faUserClock, faThumbtack, faPlus, faTimes } from '@fortawesome/free-solid-svg-icons';
import { Router } from '@angular/router';
import { Title } from '@angular/platform-browser';

@Component({
  selector: 'app-portal',
  templateUrl: './portal.component.html',
  styleUrls: ['./portal.component.css']
})
export class PortalComponent implements OnInit {

  constructor(
    private date: DatePipe,
    private register: RegisterService,
    private router: Router,
    private title: Title,
    private settings: SettingsService
  ) { }

  // Variabelen declareren
  curDate = this.date.transform(new Date(), 'yyyy-MM-dd');

  // Booleans voor de klok child forms
  showNoreg;
  showStartreg;
  showAllreg;

  // Response variabelen voor data
  response;
  allRegs;
  saldo;
  message;
  errors;
  name: string;

  // Font awesome iconen laden
  faStopwatch = faStopwatch;
  faUserClock = faUserClock;
  faThumThack = faThumbtack;
  faAdd = faPlus;
  faCross = faTimes;

  // Uitvoeren bij inladen component
  ngOnInit(): void {
    this.title.setTitle('RoosterApp - Klokken');

    // Gegevens ophalen van back-end
    this.getData();
    this.doGetName();
  }

  // Verzamelmethode die aangroepen wordt om nieuwe data op te vragen bij de back-end
  getData(): void {
    // Booleans voor de child forms resetten
    this.showNoreg = false;
    this.showStartreg = false;
    this.showAllreg = false;

    // Data ophalen
    this.doGetRegistration();
    this.doGetRegistrations();
    this.doGetSaldo();
  }

  // Methode die de registratie van vandaag ophaalt
  doGetRegistration(): void {
    // GET request naar API sturen om data van huidige datum op te halen
    this.register.getRegistration(this.curDate).subscribe(resp => {
      this.response = resp.body;
      console.log(resp.body);

      // Scenario 1: er is geen registratie
      if (!this.response) {
        this.showNoreg = true;
      }
      // Scenario 2: er is een start registratie
      else if (this.response.end === '00:00:00') {
        this.showStartreg = true;
      }
      // Scenario 3: gebruiker heeft start en eind geregistreerd
      else if (this.response.end !== '00:00:00') {
        this.showAllreg = true;
      }
    });
  }

  // Methode die alle registraties ophaalt
  doGetRegistrations(): void {
    // GET Request naar API sturen om alle registraties op te halen
    this.register.getRegistrations().subscribe(resp => {
      this.allRegs = resp.body;
    });
  }

  // Methode die de saldo informatie ophaalt
  doGetSaldo(): void {
    // GET Request naar API sturen om saldo op te halen
    this.register.getSaldo().subscribe(resp => {
      console.log(resp);
      this.saldo = resp.body.saldo;
    });
  }

  // Naam gebruiker ophalen
  doGetName(): void {
    this.settings.getUserinfo().subscribe(
      response => {
        this.name = response.body.data.name;
      }
    );
  }

  // click functie voor het bewerken van een registratie
  editReg(id): void {
    this.router.navigate(['editreg/' + id]);
  }

  submitUrenOpnemen(formdata): void {
    this.register.urenOpnemen(formdata).subscribe(
      response => {
        console.log(response);
        this.message = response.body.message;
        this.getData();
      }, error => {
        console.log(error);
        this.errors = error.error;
      }
    );
  }

}
