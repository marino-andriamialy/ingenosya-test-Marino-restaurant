import { Component, OnInit, ViewChild, AfterViewInit } from '@angular/core';
import { Repas } from '../types/repas';
import { MenusRepas, Menus } from '../types/menus';
import { MatPaginator } from '@angular/material/paginator';
import { MatTableDataSource } from '@angular/material/table';
import { MatSnackBar } from '@angular/material/snack-bar';
import { RepaService } from '../services/repa.service';
import { MenuService } from '../services/menu.service';
import {MatDialog, MAT_DIALOG_DATA} from '@angular/material/dialog';
@Component({
  selector: 'app-repas',
  templateUrl: './repas.component.html',
  styleUrls: ['./repas.component.css']
})
export class RepasComponent implements OnInit, AfterViewInit {
  repa: Repas = {
    id: 1,
    nom: 'Windstorm',
    prix: 'litre',
    creeLe: '2.5'
  };
  public listMenus: MenusRepas[] = [];
  public AllMenus: Menus[];
  // repas = REPAS;
  repas: Repas[] = [];
  Item: any;
  dataSource: any;
  isAdd: boolean;
  isModif: boolean;
  @ViewChild(MatPaginator) paginator: MatPaginator;
  @ViewChild('mytemplate') mytemplate;
  displayedColumns: string[] = ['id', 'nom', 'prix'];
  selectedRepas?: Repas;
  constructor(private _snackBar: MatSnackBar,
    private repaService: RepaService,
    private menuService: MenuService,
    public dialog: MatDialog) { }

  ngOnInit(): void {
    this.getRepas();
    this.menuService.getMenus()
    .subscribe(dataArray => this.AllMenus = dataArray);
  }
  getRepas(): void {
    //this.repas = this.repaService.getRepas();
    //this.dataSource = new MatTableDataSource<Repas>(this.repas);
    this.repaService.getRepas()
      .subscribe(repas => this.dataSource = new MatTableDataSource<Repas>(repas));

  }
  ngAfterViewInit() {
    this.dataSource.paginator = this.paginator;
  }

  onSelect(repas: Repas): void {
    this.isModif =true;
    this.selectedRepas = repas;
    this.repaService.getRepasMenus(repas.id)
    .subscribe(result => this.listMenus = result);
  }

  openModal(templateRef, menuSelected, quantiteSelected) {
    this.Item = {menuSelected: menuSelected, quantiteSelected: quantiteSelected};
    let dialogRef = this.dialog.open(templateRef, {
    });

    dialogRef.afterClosed().subscribe(result => {
        console.log('The dialog was closed');
        // this.animal = result;
    });
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
    //this.dataSource = new MatTableDataSource<Repas>(REPAS);
    delete this.selectedRepas;
    delete this.listMenus;
    this.getRepas();
  }

  modificationRepa() {
   
    if (this.selectedRepas) {
      this.repaService.updateRepas({menu: this.listMenus, repa: this.selectedRepas})
        .subscribe(function() {
          
        });
        this.openSnackBar("Modification effectuée avec succès");
        delete this.selectedRepas;
        delete this.listMenus;
        this.isModif =false;
        this.getRepas();
    }
    

  }

  addItem(result){
    // id?: number;
    // nom: string;
    // quantite: string;
    // prixUnitaire: string;
    const found = this.listMenus.find(element => element.menuId === result.menu.id);
    if(found){
        found.nom= result.menu.nom;
        found.menuId=result.menu.id;
        found.quantite= result.quantite;
      this.listMenus.map(obj => (obj.menuId === found.menuId)? found : obj);
    }else{
      this.listMenus.push({
        nom: result.menu.nom,
        menuId:result.menu.id,
        prixUnitaire:result.menu.prixUnitaire,
        quantite: result.quantite
      });
    }
   
  }
  enregistrementRepa() {
   
    if (this.selectedRepas) {
      this.repaService.saveRepas({menu: this.listMenus, repa: this.selectedRepas})
        .subscribe(function() {
          
        });

    }
    this.openSnackBar("Enregistrement effectuée avec succès");
    delete this.selectedRepas;
    delete this.listMenus;
    this.isAdd =false;
    this.getRepas();

  }

  creationRepa(){
    this.isAdd =true;
    this.selectedRepas = {
      id: 0,
      nom: '',
      prix: ''
    };
  }

}

