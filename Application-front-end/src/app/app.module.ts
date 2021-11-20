import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppComponent } from './app.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { IngredientsComponent } from './ingredients/ingredients.component';
import { FormsModule } from '@angular/forms';
import {MatTableModule} from '@angular/material/table';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import {MatPaginatorModule} from '@angular/material/paginator';
import {MatButtonModule} from '@angular/material/button';
import {MatSnackBarModule} from '@angular/material/snack-bar';
import { HttpClientModule } from '@angular/common/http';
import { MenusComponent } from './menus/menus.component';
import { AppRoutingModule } from './app-routing.module';
import {MatMenuModule} from '@angular/material/menu';
import { RepasComponent } from './repas/repas.component';
import { VentesComponent } from './ventes/ventes.component';
import {MatDialogModule} from '@angular/material/dialog';
import { DialogComponent } from './dialog/dialog.component';
import {MatChipsModule} from '@angular/material/chips';
import { MatSelectModule } from "@angular/material/select";
import { DialogRepasComponent } from './dialog-repas/dialog-repas.component';
import { MatCheckboxModule } from '@angular/material/checkbox';
@NgModule({
  declarations: [
    AppComponent,
    IngredientsComponent,
    MenusComponent,
    RepasComponent,
    VentesComponent,
     DialogComponent,
     DialogRepasComponent
  ],
  imports: [
    BrowserModule,
    BrowserAnimationsModule,
    FormsModule,
    MatTableModule,
    MatFormFieldModule,
    MatInputModule,
    MatPaginatorModule,
    MatButtonModule,
    MatSnackBarModule,
    HttpClientModule,
    AppRoutingModule,
    MatMenuModule,
    MatDialogModule,
    MatChipsModule,
    MatSelectModule,
    MatCheckboxModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
