import { Component, OnInit } from '@angular/core';
import { CursosService } from '../../services/cursos.service';
import { Curso } from '../../models/cursos';
import { Router, ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-cursos-detail',
  templateUrl: './cursos-detail.component.html',
  styleUrls: ['./cursos-detail.component.css']
})
export class CursosDetailComponent implements OnInit {

  curso: Curso = {
    id: 0,
    temaid: 0,
    personaid: 0,
    codigo: '',
    nombre: '',
    descripcion: '',
    status: 0,
    nombreTutor: '',
    apellidos: '',
    fechaRegistro:''
}

  constructor(private cursosService: CursosService, private router:Router, private activedRouter:ActivatedRoute) { }

  ngOnInit(): void {

    const params = this.activedRouter.snapshot.params;
    if (params['id']) {
      console.log(params['id']);
      this.getCurso(params['id']);
      
    }
  }

  getCurso(id:string){
    this.cursosService.getCurso(id).subscribe(
      (res: any) => {
        this.curso.id = res.data.idcurso;
        this.curso.temaid = res.data.temaid;
        this.curso.personaid = res.data.personaid;
        this.curso.codigo = res.data.codigo;
        this.curso.nombre = res.data.nombre;
        this.curso.descripcion = res.data.descripcion;
        this.curso.status = res.data.status;
        this.curso.nombreTutor = res.data.nombretutor;
        this.curso.apellidos = res.data.apellidos;
        this.curso.fechaRegistro = res.data.fechaRegistro;
        
        //console.log(this.curso);
        
      },
      ( error : any) => console.error("error", error)
    )
}

}
