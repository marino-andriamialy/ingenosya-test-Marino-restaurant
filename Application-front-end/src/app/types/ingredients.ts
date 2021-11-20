export interface Ingredients {
    id: number;
    nom: string;
    unite: string;
    stock: string;
  }

export interface IngredientsMenu {
    id?: number;
    nom: string;
    unite: string;
    quantite: string;
    stock?: string;
    menuId?: number;
    ingredientId?: number;
  }