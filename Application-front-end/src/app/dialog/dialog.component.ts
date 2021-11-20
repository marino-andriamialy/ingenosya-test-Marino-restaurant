
import { Component, Output, Input, EventEmitter, OnInit, AfterViewInit , SimpleChanges} from '@angular/core';
import {MatDialog, MatDialogRef, MAT_DIALOG_DATA} from '@angular/material/dialog';
import { Ingredients } from '../types/ingredients';

export interface DialogData {
  ingredient: string;
  quantite: string;
}
@Component({
  selector: 'app-dialog',
  templateUrl: './dialog.component.html',
  styleUrls: ['./dialog.component.css']
})


export class DialogComponent implements OnInit,AfterViewInit {

  @Output() newItemEvent = new EventEmitter<any>();
  @Input() Ingredients: Ingredients[] = [];
  @Input() selcectedItem: any;
  public ingredientSelected: number;
  public quantiteSelected: any;
  arryIngredient = [];
  constructor() {}

  ngOnInit(): void {

  }

  ngOnChanges(changes: SimpleChanges) {
    this.ingredientSelected =parseInt(changes.selcectedItem.currentValue.ingredientSelected);
    console.log("this.ingredientSelected: ",this.ingredientSelected);
    this.quantiteSelected =changes.selcectedItem.currentValue.quantiteSelected;
    //console.log(changes.Ingredients.currentValue);
    this.arryIngredient = changes.Ingredients.currentValue;

    // changes.prop contains the old and the new value...
  }

  ngAfterViewInit(): void {
    console.log("hereeeeeeee");
    
    
  }

  onValidate(ingredientSelected,quantiteSelected): void {
    let selected;
    for (let ingredient of this.arryIngredient){
      if(ingredient.id == ingredientSelected){
        selected =ingredient;
      }
    }
    let data = {ingredient: selected,quantite: quantiteSelected}
    this.newItemEvent.emit(data);
  }

}
