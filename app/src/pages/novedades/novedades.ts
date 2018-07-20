import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams, LoadingController, AlertController } from 'ionic-angular';
import { RestProvider } from '../../providers/rest/rest';
import { GlobalsProvider } from '../../providers/globals/globals';

/**
 * Generated class for the NovedadesPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-novedades',
  templateUrl: 'novedades.html',
})
export class NovedadesPage {
  public loading;
  novedades: any;
  path:string = "http://ezesoler.com/kirito/imgs/";

  constructor(public navCtrl: NavController, 
    public navParams: NavParams,
    public restProvider: RestProvider,
    public loadingCtrl: LoadingController,
    public alertCtrl: AlertController) {

  }

  ionViewDidLoad() {
    this.loading = this.loadingCtrl.create({content:'Cargando datos...'});
    this.loading.present();
    let data: Object = {email:GlobalsProvider.mailUser};
    this.restProvider.getNews(data)
    .then(data => {
      this.loading.dismiss();
      if(data["status"] == 1){
        this.novedades = data["news"];
      }else{
        let alert = this.alertCtrl.create({
          title: 'Error!',
          subTitle: 'Algo pasó y no se puedo traer las novedades.',
          buttons: ['Como si me importaran']
        });
        alert.present();
      }
    });
  }

}
