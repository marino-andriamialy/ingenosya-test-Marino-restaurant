import { Component, OnInit, ViewChild, AfterViewInit } from '@angular/core';
import { Ingredients } from '../types/ingredients';
import { MatPaginator } from '@angular/material/paginator';
import { MatTableDataSource } from '@angular/material/table';
import { MatSnackBar } from '@angular/material/snack-bar';
import { IngredientService } from '../services/ingredient.service';
@Component({
  selector: 'app-ingredients',
  templateUrl: './ingredients.component.html',
  styleUrls: ['./ingredients.component.css']
})

export class IngredientsComponent implements OnInit, AfterViewInit {
  ingredient: Ingredients = {
    id: 1,
    nom: 'Windstorm',
    unite: 'litre',
    stock: '2.5'
  };

  // ingredients = INGREDIENTS;
  ingredients: Ingredients[] = [];
  dataSource: any;
  isAdd: boolean;
  isModif: boolean;
  @ViewChild(MatPaginator) paginator: MatPaginator;
  displayedColumns: string[] = ['id', 'nom', 'stock', 'unite'];
  selectedIngredients?: Ingredients;
  constructor(private _snackBar: MatSnackBar,
    private ingredientService: IngredientService) { }

  ngOnInit(): void {
    this.getIngredients()
  }
  getIngredients(): void {
    //this.ingredients = this.ingredientService.getIngredients();
    //this.dataSource = new MatTableDataSource<Ingredients>(this.ingredients);
    this.ingredientService.getIngredients()
      .subscribe(ingredients => this.dataSource = new MatTableDataSource<Ingredients>(ingredients));

  }
  ngAfterViewInit() {
    this.dataSource.paginator = this.paginator;
  }

  onSelect(ingredients: Ingredients): void {
    this.isModif =true;
    this.isAdd =false;
    this.selectedIngredients = ingredients;
  }

  openSnackBar(message: string) {
    this._snackBar.open(message, 'Fermer', {
      duration: 5000
    });
  }
  applyFilter(event: Event) {
    const filterValue = (event.target as HTMLInputElement).value;
    this.dataSource.filter = filterValue.trim().toLowerCase();
  }

  annulModif() {
    //this.dataSource = new MatTableDataSource<Ingredients>(INGREDIENTS);
    delete this.selectedIngredients;
    this.getIngredients();
  }

  modificationIngredient() {
   
    if (this.selectedIngredients) {
      this.ingredientService.updateIngredients(this.selectedIngredients)
        .subscribe(function() {
          
        });
        this.openSnackBar("Modification effectuée avec succès");
        delete this.selectedIngredients;
        this.isModif =false;
        this.getIngredients();
    }
    

  }

  enregistrementIngredient() {
   
    if (this.selectedIngredients) {
      this.ingredientService.saveIngredients(this.selectedIngredients)
        .subscribe(function() {
          
        });

    }
    this.openSnackBar("Enregistrement effectuée avec succès");
    delete this.selectedIngredients;
    this.isAdd =false;
    this.getIngredients();

  }

  creationIngredient(){
    this.isAdd =true;
    this.isModif =false;
    this.selectedIngredients = {
      id: 0,
      nom: '',
      unite: '',
      stock: ''
    };
  }

}
