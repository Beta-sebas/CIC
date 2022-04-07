import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { HttpClientModule } from "@angular/common/http";

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { NavigationComponent } from './components/navigation/navigation.component';
import { CursosFormComponent } from './components/cursos-form/cursos-form.component';
import { CursosListComponent } from './components/cursos-list/cursos-list.component';
import { CursosService } from './services/cursos.service';
import { FormsModule } from "@angular/forms";
import { CursosDetailComponent } from './components/cursos-detail/cursos-detail.component';
import { TemasListComponent } from './components/temas-list/temas-list.component';
import { TemasFormComponent } from './components/temas-form/temas-form.component';

@NgModule({
  declarations: [
    AppComponent,
    NavigationComponent,
    CursosFormComponent,
    CursosListComponent,
    CursosDetailComponent,
    TemasListComponent,
    TemasFormComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule,
    FormsModule
  ],
  providers: [
    CursosService
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
