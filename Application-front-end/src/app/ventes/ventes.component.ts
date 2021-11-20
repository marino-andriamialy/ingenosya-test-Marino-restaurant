import { Component, OnInit, ViewChild, AfterViewInit } from '@angular/core';
import { Ventes, VentesIngredient } from '../types/ventes';
import { Repas } from '../types/repas';
import { MenusRepas, Menus } from '../types/menus';
import { MatPaginator } from '@angular/material/paginator';
import { MatTableDataSource } from '@angular/material/table';
import { MatSnackBar } from '@angular/material/snack-bar';
import { VenteService } from '../services/vente.service';
import { RepaService } from '../services/repa.service';
import {MatDialog, MAT_DIALOG_DATA} from '@angular/material/dialog';
@Component({
  selector: 'app-ventes',
  templateUrl: './ventes.component.html',
  styleUrls: ['./ventes.component.css']
})
export class VentesComponent implements OnInit, AfterViewInit {
  vente: Ventes = {
    id: 0,
      repasId: 0,
      quantite: "",
      emballages: "",
      serviettes: "",
      prix: 0,
      couvert:"",
  };
  public listMenus: MenusRepas[] = [];
  // ventes = VENTES;
  ventes: Ventes[] = [];
  toutRepas: Repas[] = [];
  dataSource: any;
  dataSource2:  any;
  multipe: Number =1;
  isAdd: boolean=false;
  isModif: boolean=false;
  isAffichage: boolean =true;
  nomRepasSelected : string ="";
  @ViewChild(MatPaginator) paginator: MatPaginator;
  @ViewChild('mytemplate') mytemplate;
  displayedColumns: string[] = ['id', 'repasId', 'quantite', 'prix', 'benefice'];
  displayedColumns2: string[] = ['nom', 'quantite', 'stock', 'prix'];
  selectedVentes?: Ventes;
  constructor(private _snackBar: MatSnackBar,
    private venteService: VenteService,
    private repaService: RepaService,
    public dialog: MatDialog) { }

  ngOnInit(): void {
    this.getVentes(),
    this.repaService.getRepas()
      .subscribe(repas => this.toutRepas = repas);
  }
  getVentes(): void {
    //this.ventes = this.venteService.getVentes();
    //this.dataSource = new MatTableDataSource<Ventes>(this.ventes);
    this.venteService.getVentes()
      .subscribe(ventes => this.dataSource = new MatTableDataSource<Ventes>(ventes));

  }
  ngAfterViewInit() {
    this.dataSource.paginator = this.paginator;
  }

  openModal(templateRef) {
    
    let dialogRef = this.dialog.open(templateRef, {
    });
    dialogRef.afterClosed().subscribe(result => {
        console.log('The dialog was closed');
        // this.animal = result;
    });
  }

  repasNgmodelchange(value){
      console.log(value);          //Changed Value
      
      this.venteService.getVentesIngredient(value)
      .subscribe(ventesdata => this.dataSource2 = new MatTableDataSource<VentesIngredient>(ventesdata));

      this.repaService.getRepasMenus(value)
      .subscribe(result => this.listMenus = result);
      //Changed Value
  }

  quantiteNgmodelchange(value){
   this.multipe = value;
    //Changed Value
  }

  onSelect(ventes: Ventes): void {
    this.isModif =true;
    this.isAffichage =false;
    this.multipe = parseInt(ventes.quantite);
    this.selectedVentes = ventes;
    this.venteService.getVentesIngredient(ventes.repasId)
    .subscribe(ventesdata => this.dataSource2 = new MatTableDataSource<VentesIngredient>(ventesdata));

    this.repaService.getRepasMenus(ventes.repasId)
    .subscribe(result => this.listMenus = result);
  }

  emballages(event){
    event? this.selectedVentes.prix += 20 : this.selectedVentes.prix -=20;
  }

  serviettes(event){
    event? this.selectedVentes.prix += 20 : this.selectedVentes.prix -=20;
  }

  couvert(event){
    event? this.selectedVentes.prix += 20 : this.selectedVentes.prix -=20;
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
    //this.dataSource = new MatTableDataSource<Ventes>(VENTES);
    delete this.selectedVentes;
    delete this.dataSource2;
    delete this.dataSource;
    delete this.listMenus;
    this.getVentes();
    this.isAdd=false;
    this.isModif=false;
  }

  modificationVente() {
   
    if (this.selectedVentes) {
      this.venteService.updateVentes(this.selectedVentes)
        .subscribe(function() {
          
        });
        this.openSnackBar("Modification effectuée avec succès");
        delete this.selectedVentes;
        this.isModif =false;
        this.getVentes();
    }
    

  }

  enregistrementVente() {
   
    for(let repa of this.toutRepas){
      if(repa.id == this.selectedVentes.repasId){
        this.nomRepasSelected = repa.nom;
      }
    }

    if (this.selectedVentes) {
      this.venteService.saveVentes(this.selectedVentes)
        .subscribe(function() {
          
        });

    }
    this.openSnackBar("Enregistrement effectuée avec succès");
    delete this.selectedVentes;
    this.isAdd =false;
    this.getVentes();

  }

  creationVente(){
    this.isAdd =true;
    this.selectedVentes = {
      id: 0,
      repasId: 0,
      quantite: "",
      emballages: "",
      serviettes: "",
      prix: 0,
      couvert:"",
    };
  }

}
