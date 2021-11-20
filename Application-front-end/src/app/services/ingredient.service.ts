import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { catchError, map, tap } from 'rxjs/operators';
import { Ingredients } from '../types/ingredients';
import { INGREDIENTS } from '../types/mock-ingredients';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { environment } from '../../environments/environment';
@Injectable({
  providedIn: 'root'
})

export class IngredientService {
  //private heroesUrl = 'http://localhost:8000/';  // URL to web api
  private heroesUrl = environment.apiURL;
  httpOptions = {
    headers: new HttpHeaders({ 'Content-Type': 'application/json' })
  };
  constructor(private http: HttpClient, ) { }

  getIngredients(): Observable<Ingredients[]> {

    // const ingredients = of(INGREDIENTS);
    // return ingredients;
    return this.http.get<Ingredients[]>(this.heroesUrl + "tout-ingredient").pipe(
      tap(_ => this.log('fetched ingredients')),
      catchError(this.handleError<Ingredients[]>('getHeroes', []))
    );
  }

  
  /** PUT: update the hero on the server */
  updateIngredients(ingredients: Ingredients): Observable<any> {
    return this.http.put(this.heroesUrl+"modify-ingredient", ingredients, this.httpOptions).pipe(
      tap(_ => this.log(`updated ingredients id=${ingredients.id}`)),
      catchError(this.handleError<any>('updateIngredients'))
    );
  }

  /** POST: add a new hero to the server */
  saveIngredients(ingredients: Ingredients): Observable<Ingredients> {
  return this.http.post<Ingredients>(this.heroesUrl+"add-ingredient", ingredients, this.httpOptions).pipe(
    tap((newIngredients: Ingredients) => this.log(`added newIngredients w/ id=${newIngredients.id}`)),
    catchError(this.handleError<Ingredients>('addHero'))
  );
}

  /**
 * Handle Http operation that failed.
 * Let the app continue.
 * @param operation - name of the operation that failed
 * @param result - optional value to return as the observable result
 */
  private handleError<T>(operation = 'operation', result?: T) {
    return (error: any): Observable<T> => {

      // TODO: send the error to remote logging infrastructure
      console.error(error); // log to console instead

      // TODO: better job of transforming error for user consumption
      this.log(`${operation} failed: ${error.message}`);

      // Let the app keep running by returning an empty result.
      return of(result as T);
    };
  }

  /** Log a HeroService message with the MessageService */
  private log(message: string) {
    console.log(`IngredientService: ${message}`);
  }
}
