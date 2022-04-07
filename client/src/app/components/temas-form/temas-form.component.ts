import { Component, OnInit } from '@angular/core';
import { Tema } from '../../models/temas';
import { CursosService } from '../../services/cursos.service';
import { Router } from '@angular/router';

@Component({
    selector: 'app-temas-form',
    templateUrl: './temas-form.component.html',
    styleUrls: ['./temas-form.component.css']
})
export class TemasFormComponent implements OnInit {

    temas: Tema = {
        nombre: '',
        descripcion: '',
        status: 0

    }

    constructor(public cursoService: CursosService, private router: Router) { }

    ngOnInit(): void {
    }

    saveNewTema() {
        this.cursoService.insertTema(this.temas).subscribe(
            (res: any) => {
                if (res.status) {
                    this.router.navigateByUrl('/temas');
                } else {
                    alert(res.msg);
                }

            }

        )

    }

}
