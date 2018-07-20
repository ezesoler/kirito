import { BrowserModule } from '@angular/platform-browser';
import { ErrorHandler, NgModule } from '@angular/core';
import { IonicApp, IonicErrorHandler, IonicModule } from 'ionic-angular';
import { SplashScreen } from '@ionic-native/splash-screen';
import { StatusBar } from '@ionic-native/status-bar';
import { IonicStorageModule } from '@ionic/storage';

import { MyApp } from './app.component';
import { HomePage } from '../pages/home/home';
import { RestProvider } from '../providers/rest/rest';
import { HttpClientModule } from '@angular/common/http';
import { GlobalsProvider } from '../providers/globals/globals';
import { CodePage } from '../pages/code/code';
import { PrediccionesPage } from '../pages/predicciones/predicciones';
import { RankingPage } from '../pages/ranking/ranking';
import { EstadisticasPage } from '../pages/estadisticas/estadisticas';
import { NovedadesPage } from '../pages/novedades/novedades';
import { ResultadosPage } from '../pages/resultados/resultados';
import { Push } from '@ionic-native/push';
import { UpdatePage } from '../pages/update/update';
import { AboutPage } from '../pages/about/about';
import { PartidoPage } from '../pages/partido/partido';
import { MensajeriaPage } from '../pages/mensajeria/mensajeria';
import { HoyPage } from '../pages/hoy/hoy';

@NgModule({
  declarations: [
    MyApp,
    HomePage,
    CodePage,
    PrediccionesPage,
    RankingPage,
    EstadisticasPage,
    NovedadesPage,
    ResultadosPage,
    UpdatePage,
    AboutPage,
    PartidoPage,
    MensajeriaPage,
    HoyPage
  ],
  imports: [
    BrowserModule,
    HttpClientModule,
    IonicModule.forRoot(MyApp),
    IonicStorageModule.forRoot()
  ],
  bootstrap: [IonicApp],
  entryComponents: [
    MyApp,
    HomePage,
    CodePage,
    PrediccionesPage,
    RankingPage,
    EstadisticasPage,
    NovedadesPage,
    ResultadosPage,
    UpdatePage,
    AboutPage,
    PartidoPage,
    MensajeriaPage,
    HoyPage
  ],
  providers: [
    StatusBar,
    SplashScreen,
    {provide: ErrorHandler, useClass: IonicErrorHandler},
    RestProvider,
    GlobalsProvider,
    Push
  ]
})
export class AppModule {}
