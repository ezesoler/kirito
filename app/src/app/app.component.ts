import { Component, ViewChild } from '@angular/core';
import { Nav, Platform } from 'ionic-angular';
import { StatusBar } from '@ionic-native/status-bar';
import { SplashScreen } from '@ionic-native/splash-screen';
import { Push, PushObject, PushOptions } from '@ionic-native/push';

import { HomePage } from '../pages/home/home';
import { PrediccionesPage } from '../pages/predicciones/predicciones';
import { RankingPage } from '../pages/ranking/ranking';
import { EstadisticasPage } from '../pages/estadisticas/estadisticas';
import { NovedadesPage } from '../pages/novedades/novedades';
import { ResultadosPage } from '../pages/resultados/resultados';
import { RestProvider } from '../providers/rest/rest';
import { GlobalsProvider } from '../providers/globals/globals';
import { UpdatePage } from '../pages/update/update';
import { AboutPage } from '../pages/about/about';
import { MensajeriaPage } from '../pages/mensajeria/mensajeria';
import { HoyPage } from '../pages/hoy/hoy';
@Component({
  templateUrl: 'app.html'
})
export class MyApp {
  @ViewChild(Nav) nav: Nav;
  rootPage:any = HomePage;
  activePage:any;
  pages: Array<{title: string, component: any}>;

  constructor(platform: Platform, 
    statusBar: StatusBar, 
    splashScreen: SplashScreen, 
    private push: Push,
    public restProvider: RestProvider) {
    platform.ready().then(() => {
      // Okay, so the platform is ready and our plugins are available.
      // Here you can do any higher level native things you might need.
      statusBar.styleDefault();
      statusBar.styleLightContent()
      splashScreen.hide();
      this.pushSetup();
      this.checkVersion();
    });

    this.pages = [
      { title: 'Partidos de Hoy', component: HoyPage },
      { title: 'Predicciones', component: PrediccionesPage },
      { title: 'Resultados', component: ResultadosPage },
      { title: 'Ranking', component: RankingPage },
      { title: 'Mis Estadísticas', component: EstadisticasPage },
      { title: 'Novedades', component: NovedadesPage },
      { title: 'Forobardo', component: MensajeriaPage },
      { title: 'Sobre la app', component: AboutPage }
    ];

    this.activePage = this.pages[0];
  }

  openPage(page) {
    // Reset the content nav to have just this page
    // we wouldn't want the back button to show in this scenario
    //this.nav.push(page.component);
    if(page.title == "Partidos de Hoy"){
      this.nav.setRoot(page.component);
    }else{
      this.nav.setRoot(HoyPage).then(data => {
        this.nav.push(page.component);
      });
    }
    this.activePage = page;
  }

  checkActive(page){
    return page == this.activePage;
  }

  checkVersion() {
    let data: Object = {};
    this.restProvider.getVersionApp(data)
    .then(data => {
        if(Number(data["version"]) > GlobalsProvider.versionApp){
          this.nav.setRoot(UpdatePage);
        }
    });
  }

  get count() { return GlobalsProvider.unreadMsgs; }

  pushSetup(){

    // to check if we have permission
      this.push.hasPermission()
      .then((res: any) => {

        if (res.isEnabled) {
          console.log('We have permission to send push notifications');
        } else {
          console.log('We do not have permission to send push notifications');
        }

      });

      // Create a channel (Android O and above). You'll need to provide the id, description and importance properties.
      this.push.createChannel({
        id: "kirito",
        description: "Canal Kirito",
        // The importance property goes from 1 = Lowest, 2 = Low, 3 = Normal, 4 = High and 5 = Highest.
        importance: 3
      }).then(() => console.log('Channel created'));
      

      const options: PushOptions = {
        android: {
          senderID: '287838448214',
          sound: 'true',
          vibrate: 'true',
          icon: './assets/imgs/icon',
          iconColor: './assets/imgs/icon_color'
        },
        ios: {
            alert: 'true',
            badge: true,
            sound: 'false'
        }
    };
    
    const pushObject: PushObject = this.push.init(options);
    
    
    pushObject.on('notification').subscribe((notification: any) => {
      console.log('Received a notification', notification);
      GlobalsProvider.redirect = notification.additionalData.type;
    });
    
    pushObject.on('registration').subscribe((registration: any) => {
      console.log('Device registered', registration);
      GlobalsProvider.tfcm = registration.registrationId;
      pushObject.subscribe("kirito").then((res:any) => {
        console.log("subscribed to topic: ", res);
      });
    });
    
    pushObject.on('error').subscribe(error => console.error('Error with Push plugin', error));
  }
}

