import { Ingredients } from './ingredients';
export interface Menus {
    id: number;
    nom: string;
    prixUnitaire: string;
    ingredients?: Ingredients[];
  }

  export interface MenusRepas {
    id?: number;
    nom: string;
    quantite: string;
    prixUnitaire: string;
    menuId?: number;
    repasId?: number;
  }
