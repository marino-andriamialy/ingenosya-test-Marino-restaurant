import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { catchError, map, tap } from 'rxjs/operators';
import { Repas } from '../types/repas';
import { MenusRepas, Menus } from '../types/menus';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { environment } from '../../environments/environment';
@Injectable({
  providedIn: 'root'
})
export class RepaService {
  //private heroesUrl = 'http://localhost:8000/';  // URL to web api
  private heroesUrl = environment.apiURL;
  httpOptions = {
    headers: new HttpHeaders({ 'Content-Type': 'application/json' })
  };
  constructor(private http: HttpClient, ) { }

  getRepas(): Observable<Repas[]> {

    // const repas = of(REPAS);
    // return repas;
    return this.http.get<Repas[]>(this.heroesUrl + "tout-repa").pipe(
      tap(_ => this.log('fetched repas')),
      catchError(this.handleError<Repas[]>('getHeroes', []))
    );
  }
  
  getRepasMenus(id): Observable<MenusRepas[]> {
    return this.http.get<MenusRepas[]>(this.heroesUrl + "tout-repas-menu/"+id).pipe(
      tap(_ => this.log('fetched menus')),
      catchError(this.handleError<MenusRepas[]>('getHeroes', []))
    );
  }
  /** PUT: update the hero on the server */
  updateRepas(repas: any): Observable<any> {
    return this.http.put(this.heroesUrl+"modify-repa", repas, this.httpOptions).pipe(
      tap(_ => this.log(`updated repas id=${repas.id}`)),
      catchError(this.handleError<any>('updateRepas'))
    );
  }

  /** POST: add a new hero to the server */
  saveRepas(repas: any): Observable<Repas> {
  return this.http.post<any>(this.heroesUrl+"add-repa", repas, this.httpOptions).pipe(
    tap((newRepas: any) => this.log(`added newRepas w/ id=${newRepas.id}`)),
    catchError(this.handleError<any>('addHero'))
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
    console.log(`RepaService: ${message}`);
  }
}
