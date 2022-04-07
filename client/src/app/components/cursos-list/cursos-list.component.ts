import { Component, OnInit } from '@angular/core';
import { CursosService } from "../../services/cursos.service";
import { Curso } from '../../models/cursos';

@Component({
    selector: 'app-cursos-list',
    templateUrl: './cursos-list.component.html',
    styleUrls: ['./cursos-list.component.css']
})
export class CursosListComponent implements OnInit {

    cursos: any = [];
    //min:number = 1;
    //max:number = 1000;
    //numero:number =  Math.random() * (1000 - 1) + 1;

    constructor(private cursosService: CursosService) { }

    ngOnInit(): void {

        this.getCursos();

    }

    getCursos(){
        this.cursosService.getCursos().subscribe(
            res => {
                this.cursos = res;
                console.log(this.cursos);

            },
            err => console.error("error", err)
        )
    }

    deleteCurso(id:string){
        this.cursosService.deleteCurso(id).subscribe(
            (res: any) => {
                if (res.status) {
                    this.getCursos();
                }
            },
            err => console.log(err)
            
        )
        
    }

   

}
