import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { CursosListComponent } from './components/cursos-list/cursos-list.component';
import { CursosFormComponent } from './components/cursos-form/cursos-form.component';
import { CursosDetailComponent } from './components/cursos-detail/cursos-detail.component';
import { TemasListComponent } from './components/temas-list/temas-list.component';
import { TemasFormComponent } from './components/temas-form/temas-form.component';

const routes: Routes = [
  {
    path: '',
    redirectTo: '/cursos',
    pathMatch: 'full' 
  },
  {
    path: 'cursos',
    component: CursosListComponent
  },
  {
    path: 'cursos/add',
    component: CursosFormComponent
  },
  {
    path: 'cursos/edit/:id',
    component: CursosFormComponent
  },
  {
    path: 'cursos/view/:id',
    component: CursosDetailComponent
  },
  {
    path: 'temas',
    component: TemasListComponent
  },
  {
    path: 'temas/add',
    component: TemasFormComponent
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
