import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { CursosListComponent } from './components/cursos-list/cursos-list.component';
import { CursosFormComponent } from './components/cursos-form/cursos-form.component';

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
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
