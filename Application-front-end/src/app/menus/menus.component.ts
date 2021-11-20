import { Component, OnInit, ViewChild, AfterViewInit } from '@angular/core';
import { Ingredients, IngredientsMenu } from '../types/ingredients';
import { Menus } from '../types/menus';
import { MatPaginator } from '@angular/material/paginator';
import { MatTableDataSource } from '@angular/material/table';
import { MatSnackBar } from '@angular/material/snack-bar';
import { MenuService } from '../services/menu.service';
import {MatDialog, MAT_DIALOG_DATA} from '@angular/material/dialog';
import { IngredientService } from '../services/ingredient.service';
export interface DialogData {
  ingredient: any;
  quantite: string;
}

@Component({
  selector: 'app-menus',
  templateUrl: './menus.component.html',
  styleUrls: ['./menus.component.css']
})
export class MenusComponent implements OnInit, AfterViewInit {
  
  //ajout d'ingredient
  public ingredient: DialogData;
  public listIngredients: IngredientsMenu[] = [];
  public AllIngredients: Ingredients[];
  // menus = MENUS;
  menus: Menus[] = [];
  dataSource: any;
  Item: any;
  isAdd: boolean;
  isModif: boolean;
  @ViewChild(MatPaginator) paginator: MatPaginator;
  @ViewChild('mytemplate') mytemplate;

  displayedColumns: string[] = ['id', 'nom', 'prixUnitaire'];
  selectedMenus?: Menus;
  constructor(private _snackBar: MatSnackBar,
    private menuService: MenuService,
    public dialog: MatDialog,
    private ingredientService: IngredientService) { }

  ngOnInit(): void {
    this.getMenus();
    this.ingredientService.getIngredients()
    .subscribe(dataArray => this.AllIngredients = dataArray);
  }


  openModal(templateRef, ingredientSelected, quantiteSelected) {
      this.Item = {ingredientSelected: ingredientSelected, quantiteSelected: quantiteSelected};
      let dialogRef = this.dialog.open(templateRef, {
      });

      dialogRef.afterClosed().subscribe(result => {
          console.log('The dialog was closed');
          // this.animal = result;
      });
  }

  addItem(result){

    const found = this.listIngredients.find(element => element.ingredientId === result.ingredient.id);
    if(found){
        found.nom= result.ingredient.nom;
        found.unite=result.ingredient.unite;
        found.ingredientId=result.ingredient.id;
        found.stock=result.ingredient.stock;
        found.quantite= result.quantite;
      this.listIngredients.map(obj => (obj.ingredientId === found.ingredientId)? found : obj);
    }else{
      this.listIngredients.push({
        nom: result.ingredient.nom,
        unite:result.ingredient.unite,
        ingredientId:result.ingredient.id,
        stock:result.ingredient.stock,
        quantite: result.quantite
      });
    }
   
  }

  getMenus(): void {
    this.menuService.getMenus()
      .subscribe(menus => this.dataSource = new MatTableDataSource<Menus>(menus));
  }

  ngAfterViewInit() {
    this.dataSource.paginator = this.paginator;
  }

  onSelect(menus: Menus): void {
    this.isModif =true;
    this.isAdd =false;
    this.selectedMenus = menus;
    this.menuService.getMenusIngredient(menus.id)
    .subscribe(result => this.listIngredients = result);

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
    //this.dataSource = new MatTableDataSource<Menus>(MENUS);
    delete this.selectedMenus;
    delete this.listIngredients;
    this.getMenus();
  }

  modificationMenu() {
   
    if (this.selectedMenus) {
      this.menuService.updateMenus({ingredient: this.listIngredients, menu: this.selectedMenus})
        .subscribe(function() {
          
        });
        this.openSnackBar("Modification effectuée avec succès");
        delete this.selectedMenus;
        delete this.listIngredients;
        this.isModif =false;
        this.getMenus();
    }
    

  }

  enregistrementMenu() {
   
    if (this.selectedMenus) {
      this.menuService.saveMenus({ingredient: this.listIngredients, menu: this.selectedMenus})
        .subscribe(function() {
          
        });

    }
    this.openSnackBar("Enregistrement effectuée avec succès");
    delete this.selectedMenus;
    delete this.listIngredients;
    this.isAdd =false;
    this.getMenus();

  }

  creationMenu(){
    this.isAdd =true;
    this.isModif =false;
    this.selectedMenus = {
      id: 0,
      nom: '',
      prixUnitaire: '',
    };
  }

}

