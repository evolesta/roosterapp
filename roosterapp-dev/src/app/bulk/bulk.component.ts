import { Component, OnInit } from '@angular/core';
import { faPlus, faLevelDownAlt, faTrashAlt } from '@fortawesome/free-solid-svg-icons';
import { FormBuilder, FormGroup, FormArray } from '@angular/forms';
import { RegisterService } from '../register.service';
import { Router } from '@angular/router';
import { Title } from '@angular/platform-browser';

@Component({
  selector: 'app-bulk',
  templateUrl: './bulk.component.html',
  styleUrls: ['./bulk.component.css']
})
export class BulkComponent implements OnInit {

  // Font-awesome iconen declareren
  faPlus = faPlus;
  faLevelDown = faLevelDownAlt;
  faTrash = faTrashAlt;
  bulkForm: FormGroup;
  errors;

  constructor(
    private fb: FormBuilder,
    private register: RegisterService,
    private router: Router,
    private title: Title
  ) {
    this.bulkForm = this.fb.group({
      registration: this.fb.array([])
    });
  }

  ngOnInit(): void {
    // 1 nieuwe Array item toevoegen
    this.addRow();
    this.title.setTitle('RoosterApp - Bulk registreren');
  }

  registrations(): FormArray {
    return this.bulkForm.get('registration') as FormArray;
  }

  // Nieuwe lege array groep aanmaken
  newRegistration(): FormGroup {
    return this.fb.group({
      date: '',
      start: '',
      end: ''
    });
  }

  // Methode die een nieuwe rij toevoegt aan de array en form
  addRow(): void {
    this.registrations().push(this.newRegistration());
  }

  // Methode die een rij verwijderd uit de array
  removeRow(id): void {
    this.registrations().removeAt(id);
  }

  // Methode die alle data van het formulier naar de back-end post
  submitForm(): void {
    // Output van de array printen naar console
    console.log(this.bulkForm.value.registration);

    // Array naar back-end sturen voor verwerking
    this.register.addBulkRegistrations(this.bulkForm.value).subscribe(resp => {
      console.log(resp);

      // Gebruiker terugleiden naar overzicht
      this.router.navigateByUrl('/portal');

    }, error => {
      this.errors = error;
      console.log(error);
    });
  }
}
