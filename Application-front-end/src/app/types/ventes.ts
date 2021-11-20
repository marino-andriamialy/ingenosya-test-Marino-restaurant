export interface Ventes {
    id: number;
    repasId: number;
    quantite: string;
    emballages?: string;
    serviettes?: string;
    prix: number;
    creer_le?: string;
    couvert?:string;
    prixAchat?:string;
    nom?:string;
  }

  export interface VentesIngredient {
    id: number;
    quantite: string;
    nom?: string;
    unite?: string;
    stock: string;
    ingredientId?: string;
  }