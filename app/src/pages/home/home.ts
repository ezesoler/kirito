import { Component } from '@angular/core';
import { NavController, LoadingController, AlertController } from 'ionic-angular';
import { RestProvider } from '../../providers/rest/rest';
import { GlobalsProvider } from '../../providers/globals/globals';
import { CodePage } from '../code/code';
import { Storage } from '@ionic/storage';
import { NovedadesPage } from '../novedades/novedades';
import { ResultadosPage } from '../resultados/resultados';
import { MensajeriaPage } from '../mensajeria/mensajeria';
import { HoyPage } from '../hoy/hoy';

@Component({
  selector: 'page-home',
  templateUrl: 'home.html'
})
export class HomePage {
  public email:string;
  public loading;
  
  constructor(public navCtrl: NavController, 
    public restProvider: RestProvider,
    public loadingCtrl: LoadingController,
    public alertCtrl: AlertController,
    public storage: Storage) {

    storage.get('lastmsg').then((val) => {
      if(val != null){
        GlobalsProvider.lastMsg = val;
      }
    });

    storage.get('email').then((val) => {
      if(val != null){
        GlobalsProvider.mailUser = val;
        storage.get('token').then((val) => {
          GlobalsProvider.token = val;
          if(GlobalsProvider.redirect == "news"){
            this.navCtrl.setRoot(NovedadesPage);
          }else if(GlobalsProvider.redirect == "results"){
            this.navCtrl.setRoot(ResultadosPage);
          }else if(GlobalsProvider.redirect == "menssage"){
            this.navCtrl.setRoot(MensajeriaPage);
          }else{
            this.navCtrl.setRoot(HoyPage);
          }
        });
      }
    });
  }

  checkMail() {
    let alert;
    if((this.email == "") || (this.email == null)){
      alert = this.alertCtrl.create({
        title: 'Error!',
        subTitle: 'Ah so vivo vo? Poné un mail.',
        buttons: ['Me parece bien']
      });
      alert.present();
    }else if(this.validateEmail(this.email)){
      alert = this.alertCtrl.create({
        title: 'Error!',
        subTitle: 'El mail no es correcto, papirulo/a.',
        buttons: ['Soy menso/a']
      });
      alert.present();
    }else{
      this.loading = this.loadingCtrl.create({content:'Enviando datos...'});
      this.loading.present();
      let data: Object = {email:this.email};
      this.restProvider.checkMail(data)
      .then(data => {
        this.loading.dismiss();
        if(data["status"] == 1){
          GlobalsProvider.mailUser = this.email;
          GlobalsProvider.token = data["token"];
          this.navCtrl.setRoot(CodePage);
        }else{
          this.email = "";
          alert = this.alertCtrl.create({
            title: 'Error!',
            subTitle: 'El mail que ingresaste no está en la lista de usuarios.',
            buttons: ['Al cabo que ni queria']
          });
          alert.present();
        }
      });
    }
  }

  validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return !re.test(email);
  } 

}
