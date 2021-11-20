import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { IngredientsComponent } from './ingredients/ingredients.component';
import { MenusComponent } from './menus/menus.component';
import { RepasComponent } from './repas/repas.component';
import { VentesComponent } from './ventes/ventes.component';

const routes: Routes = [
  { path: 'ingredients', component: IngredientsComponent },
  { path: 'menus', component: MenusComponent },
  { path: 'repas', component: RepasComponent },
  { path: 'ventes', component: VentesComponent }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }