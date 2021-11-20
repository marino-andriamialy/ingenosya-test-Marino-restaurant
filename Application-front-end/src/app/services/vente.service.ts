import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { catchError, map, tap } from 'rxjs/operators';
import { Ventes, VentesIngredient } from '../types/ventes';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { environment } from '../../environments/environment';
@Injectable({
  providedIn: 'root'
})
export class VenteService {
  //private heroesUrl = 'http://localhost:8000/';  // URL to web api
  private heroesUrl = environment.apiURL;
  httpOptions = {
    headers: new HttpHeaders({ 'Content-Type': 'application/json' })
  };
  constructor(private http: HttpClient, ) { }

  getVentes(): Observable<Ventes[]> {

    // const ventes = of(VENTES);
    // return ventes;
    return this.http.get<Ventes[]>(this.heroesUrl + "tout-vente").pipe(
      tap(_ => this.log('fetched ventes')),
      catchError(this.handleError<Ventes[]>('getHeroes', []))
    );
  }
  getVentesIngredient(idRepas: any): Observable<VentesIngredient[]> {
    return this.http.get<VentesIngredient[]>(this.heroesUrl + "tout-repas-menu-ingredient/"+idRepas).pipe(
      tap(_ => this.log('fetched ventes')),
      catchError(this.handleError<VentesIngredient[]>('getHeroes', []))
    );
  }
  
  /** PUT: update the hero on the server */
  updateVentes(ventes: Ventes): Observable<any> {
    return this.http.put(this.heroesUrl+"modify-vente", ventes, this.httpOptions).pipe(
      tap(_ => this.log(`updated ventes id=${ventes.id}`)),
      catchError(this.handleError<any>('updateVentes'))
    );
  }

  /** POST: add a new hero to the server */
  saveVentes(ventes: Ventes): Observable<Ventes> {
  return this.http.post<Ventes>(this.heroesUrl+"add-vente", ventes, this.httpOptions).pipe(
    tap((newVentes: Ventes) => this.log(`added newVentes w/ id=${newVentes.id}`)),
    catchError(this.handleError<Ventes>('addHero'))
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
    console.log(`VenteService: ${message}`);
  }
}

