import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { catchError, map, tap } from 'rxjs/operators';
import { Menus } from '../types/menus';
import { Ingredients, IngredientsMenu } from '../types/ingredients';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { environment } from '../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class MenuService {
  //private heroesUrl = 'http://localhost:8000/';  // URL to web api
  private heroesUrl = environment.apiURL;  // URL to web api
  httpOptions = {
    headers: new HttpHeaders({ 'Content-Type': 'application/json' })
  };
  constructor(private http: HttpClient, ) { }

  getMenus(): Observable<Menus[]> {

    // const menus = of(MENUS);
    // return menus;
    return this.http.get<Menus[]>(this.heroesUrl + "tout-menu").pipe(
      tap(_ => this.log('fetched menus')),
      catchError(this.handleError<Menus[]>('getHeroes', []))
    );
  }

  getMenusIngredient(id): Observable<IngredientsMenu[]> {
    return this.http.get<IngredientsMenu[]>(this.heroesUrl + "tout-menu-ingredient/"+id).pipe(
      tap(_ => this.log('fetched menus')),
      catchError(this.handleError<IngredientsMenu[]>('getHeroes', []))
    );
  }

  
  /** PUT: update the hero on the server */
  updateMenus(menus: any): Observable<any> {
    return this.http.put(this.heroesUrl+"modify-menu", menus, this.httpOptions).pipe(
      tap(_ => this.log(`updated menus id=${menus.id}`)),
      catchError(this.handleError<any>('updateMenus'))
    );
  }

  /** POST: add a new hero to the server */
  saveMenus(menus: any): Observable<Menus> {
  return this.http.post<Menus>(this.heroesUrl+"add-menu", menus, this.httpOptions).pipe(
    tap((newMenus: Menus) => this.log(`added newMenus w/ id=${newMenus.id}`)),
    catchError(this.handleError<Menus>('addHero'))
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
    console.log(`MenuService: ${message}`);
  }
}
