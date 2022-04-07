import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { Curso } from "../models/cursos";

@Injectable({
  providedIn: 'root'
})
export class CursosService {

  REST_URI = 'http://localhost/CIC/server/Rutas';
  
  
  constructor(private http: HttpClient ) { 
    
  }

  

  getCursos(){
    return this.http.get( `${this.REST_URI}/cursos`);
  }

  getCurso( id: string){
    return this.http.get( `${this.REST_URI}/cursos?id=${id}`);
  }

  deleteCurso(id: string){
    return this.http.delete(`${this.REST_URI}/cursos?id=${id}`);
  }

  insertCurso( curso:Curso){
    return this.http.post( `${this.REST_URI}/cursos`,curso);
  }

  updateCurso(id:string, updateCurso:Curso){
    return this.http.put(`${this.REST_URI}/cursos?id=${id}`, updateCurso);
  }

  getTemas(){
    return this.http.get( `${this.REST_URI}/temas`)
  }

  getUsuarios(){
    return this.http.get( `${this.REST_URI}/usuarios`)
  }

  insertTema( tema:any){
    return this.http.post( `${this.REST_URI}/temas`,tema);
  }

  
}
