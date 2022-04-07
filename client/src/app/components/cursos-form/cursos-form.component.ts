import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { Curso } from '../../models/cursos';
import { CursosService } from '../../services/cursos.service';

@Component({
    selector: 'app-cursos-form',
    templateUrl: './cursos-form.component.html',
    styleUrls: ['./cursos-form.component.css']
})
export class CursosFormComponent implements OnInit {

    curso: Curso = {
        id: 0,
        temaid: 0,
        personaid: 0,
        codigo: '',
        nombre: '',
        descripcion: '',
        status: 0
    }

    temas: any = [];
    usuarios: any = [];

    constructor(public cursoService: CursosService, private router: Router, private activedRouter: ActivatedRoute) { }

    ngOnInit(): void {
        
        this.cursoService.getTemas().subscribe(
            (res: any) => {
                this.temas = res;
                //console.log(this.temas)
            },
            error => console.error("error", error)
        )

        this.cursoService.getUsuarios().subscribe(
            (res: any) => {
                this.usuarios = res;
                //console.log(this.usuarios)
            },
            (error: any) => console.error("error", error)
        )

        const params = this.activedRouter.snapshot.params;
        if (params['id']) {
            this.cursoService.getCurso(params['id']).subscribe(
                (res: any) => {
                    if (res.status) {
                        //console.log(res);
                        this.curso.id = res.data.idcurso;
                        this.curso.temaid = res.data.temaid;
                        this.curso.personaid = res.data.personaid;
                        this.curso.codigo = res.data.codigo;
                        this.curso.nombre = res.data.nombre;
                        this.curso.descripcion = res.data.descripcion;
                        this.curso.status = res.data.status;
                        console.log(this.curso);
                        
                    }

                },
                (error: any) => console.error("error", error)
            )
            
        }

    }

    cursos(){
        const params = this.activedRouter.snapshot.params;
        if (params['id']) {
            this.editCurso();
        }else{
            this.saveNewCurso();
        }
    }

    saveNewCurso() {
        this.cursoService.insertCurso(this.curso)
        .subscribe((res: any) => {
                if (res.status) {
                    this.router.navigateByUrl('/cursos');
                }else{
                    alert(res.msg);
                }
                
            }
            
        )
        console.log(this.curso);

    }

    editCurso(){
        const params = this.activedRouter.snapshot.params;
        this.cursoService.updateCurso(params['id'],this.curso).subscribe(
            (res: any) => {
                if (res.status) {
                    this.router.navigateByUrl('/cursos');
                }
                else{
                    alert(res.msg);
                }
            },
            (error: any) => console.error("error", error)
        )
    }

}
