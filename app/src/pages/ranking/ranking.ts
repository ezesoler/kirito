import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams, LoadingController, AlertController } from 'ionic-angular';
import { RestProvider } from '../../providers/rest/rest';
import { EstadisticasPage } from '../estadisticas/estadisticas';
import { GlobalsProvider } from '../../providers/globals/globals';

/**
 * Generated class for the RankingPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-ranking',
  templateUrl: 'ranking.html',
})
export class RankingPage {
  public loading;
  ranking: any;

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
    this.restProvider.getRanking(data)
    .then(data => {
      this.loading.dismiss();
      if(data["status"] == 1){
        this.ranking = data["ranking"];
        //this.ranking = this.sortJSON(data["ranking"],'score', '321');
        this.ranking.forEach(element => {
          element.porcentaje = Math.round(Number(((element.stats.resultados) * 100)/element.stats.partidos));
        });
        this.ranking.sort(function (a, b) {
          return a.score - b.score || a.porcentaje - b.porcentaje;
        });
        this.ranking = this.ranking.reverse();
        //this.ranking = this.sortJSON(data["ranking"],'porcentaje', '321');
        let count = 1;
        this.ranking.forEach(element => {
          element.puesto = count;
          count++;
        });
      }else{
        let alert = this.alertCtrl.create({
          title: 'Error!',
          subTitle: 'Algo pasó y no se puedo traer el ranking.',
          buttons: ['Qué aplicación del orto']
        });
        alert.present();
      }
    });
  }

  itemSelected(email){
    this.navCtrl.push(EstadisticasPage,{idUser:email});
  }

  sortJSON(data, key, way) {
    return data.sort(function(a, b) {
        var x = a[key]; var y = b[key];
        if (way === '123' ) { return ((x < y) ? -1 : ((x > y) ? 1 : 0)); }
        if (way === '321') { return ((x > y) ? -1 : ((x < y) ? 1 : 0)); }
    });
  }

}
