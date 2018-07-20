import { NgModule } from '@angular/core';
import { IonicPageModule } from 'ionic-angular';
import { PrediccionesPage } from './predicciones';

@NgModule({
  declarations: [
    PrediccionesPage,
  ],
  imports: [
    IonicPageModule.forChild(PrediccionesPage),
  ],
})
export class PrediccionesPageModule {}
