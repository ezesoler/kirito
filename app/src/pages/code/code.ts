import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams, LoadingController, AlertController } from 'ionic-angular';
import { RestProvider } from '../../providers/rest/rest';
import { GlobalsProvider } from '../../providers/globals/globals';
import { Storage } from '@ionic/storage';
import { PrediccionesPage } from '../predicciones/predicciones';


/**
 * Generated class for the CodePage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-code',
  templateUrl: 'code.html',
})
export class CodePage {
  public nombre:string;
  public codigo:string;
  public loading;

  constructor(public navCtrl: NavController, 
    public navParams: NavParams, 
    public restProvider: RestProvider,
    public loadingCtrl: LoadingController,
    public alertCtrl: AlertController,
    public storage: Storage) {
    

  }

  ionViewDidLoad() {
    //console.log('ionViewDidLoad CodePage');
  }

  sendCodeAndName() {
    let alert;
    if((this.codigo == "") || (this.codigo == null)){
        alert = this.alertCtrl.create({
          title: 'Error!',
          subTitle: 'Poné el código que te llego por mail ;)',
          buttons: ['Aaaah, claro!']
        });
        alert.present();
    }else if((this.nombre == "") || (this.nombre == null)){
        alert = this.alertCtrl.create({
          title: 'Error!',
          subTitle: 'Sería muy interesante que pongas tu nombre',
          buttons: ['Si, tiene sentido']
        });
        alert.present();
    }else if(this.nombre.length <= 2){
      alert = this.alertCtrl.create({
        title: 'Error!',
        subTitle: 'Tu nombre tiene que ser minimo de 3 letras.',
        buttons: ['Que pesado!']
      });
      alert.present();
    }else{
      this.loading = this.loadingCtrl.create({content:'Enviando datos...'});
      this.loading.present();
      let data: Object = {email:GlobalsProvider.mailUser,code:this.codigo,name:this.nombre,tfcm:GlobalsProvider.tfcm};
      this.restProvider.activateUser(data)
      .then(data => {
        this.loading.dismiss();
        console.log(data);
        if(data["status"] == 1){
          this.storage.set('nombre', this.nombre);
          this.storage.set('email', GlobalsProvider.mailUser);
          this.storage.set('token', GlobalsProvider.token);
          this.navCtrl.setRoot(PrediccionesPage);
        }else{
          this.codigo = "";
          alert = this.alertCtrl.create({
            title: 'Error!',
            subTitle: 'El código no es correcto.',
            buttons: ['Peero, la pucha']
          });
          alert.present();
        }
      });
    }
  }

}
