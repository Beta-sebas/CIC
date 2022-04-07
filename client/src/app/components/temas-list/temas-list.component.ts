import { Component, OnInit } from '@angular/core';
import { CursosService } from '../../services/cursos.service';

@Component({
  selector: 'app-temas-list',
  templateUrl: './temas-list.component.html',
  
})
export class TemasListComponent implements OnInit {

  temas: any = [];

  constructor(private cursosService: CursosService) { }

  ngOnInit(): void {
      this.getTemas();
  }

  getTemas(){
    this.cursosService.getTemas().subscribe(
      res => {
        this.temas = res;
        console.log(this.temas);

    },
    err => console.error("error", err)
    )
  }

}
