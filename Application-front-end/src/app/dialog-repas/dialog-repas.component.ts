import { Component, Output, Input, EventEmitter, OnInit, AfterViewInit , SimpleChanges} from '@angular/core';
import { Repas } from '../types/repas';
import { MenusRepas, Menus } from '../types/menus';
@Component({
  selector: 'app-dialog-repas',
  templateUrl: './dialog-repas.component.html',
  styleUrls: ['./dialog-repas.component.css']
})
export class DialogRepasComponent implements OnInit {
  @Output() newItemEvent = new EventEmitter<any>();
  @Input() Menus: Menus[] = [];
  @Input() selcectedItem: any;
  public menuSelected: number;
  public quantiteSelected: any;
  arryMenu = [];
  constructor() { }

  ngOnInit(): void {
  }
  ngOnChanges(changes: SimpleChanges) {
    this.menuSelected =parseInt(changes.selcectedItem.currentValue.menuSelected);
    console.log("this.menuSelected: ",this.menuSelected);
    this.quantiteSelected =changes.selcectedItem.currentValue.quantiteSelected;
    //console.log(changes.Ingredients.currentValue);
    this.arryMenu = changes.Menus.currentValue;

    // changes.prop contains the old and the new value...
  }

  ngAfterViewInit(): void {
    console.log("hereeeeeeee");
    
    
  }

  onValidate(menuSelected,quantiteSelected): void {
    let selected;
    for (let menu of this.arryMenu){
      if(menu.id == menuSelected){
        selected = menu;
      }
    }
    let data = {menu: selected,quantite: quantiteSelected}
    this.newItemEvent.emit(data);
  }
}
