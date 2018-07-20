import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams, LoadingController, AlertController } from 'ionic-angular';
import { RestProvider } from '../../providers/rest/rest';
import { GlobalsProvider } from '../../providers/globals/globals';

/**
 * Generated class for the EstadisticasPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-estadisticas',
  templateUrl: 'estadisticas.html',
})
export class EstadisticasPage {
  public loading;
  partidos;
  goles;
  resultados;
  efectividad;
  idUser;
  title;

  constructor(public navCtrl: NavController,
    public navParams: NavParams,
    public restProvider: RestProvider,
    public loadingCtrl: LoadingController,
    public alertCtrl: AlertController) {
      this.idUser = GlobalsProvider.mailUser;
      if(navParams.get("idUser") != 0 && navParams.get("idUser") != null && navParams.get("idUser") != "undefined"){
        this.idUser = navParams.get("idUser");
      }
  }

  ionViewDidLoad() {
    this.loading = this.loadingCtrl.create({content:'Cargando datos...'});
    this.loading.present();
    let data: Object = {email:GlobalsProvider.mailUser,idUser:this.idUser};
    this.restProvider.getStats(data)
    .then(data => {
      this.loading.dismiss();
      if(data["status"] == 1){
        if(this.idUser == GlobalsProvider.mailUser){
          this.title = "mis estadísticas";
        }else{
          this.title = "estadísticas "+ data["nombre"];
        }
        this.partidos = data["stats"].partidos;
        this.goles = data["stats"].goles;
        this.resultados = data["stats"].resultados;
        this.efectividad = Number(((this.resultados) * 100)/this.partidos).toFixed(2);
        if(isNaN(this.efectividad)){
          this.efectividad = 0;
        }
      }else{
        let alert = this.alertCtrl.create({
          title: 'Error!',
          subTitle: 'Algo pasó y no se puedo traer las estádisticas.',
          buttons: ['Y bueno, será la próxima']
        });
        alert.present();
      }
    });
  }

}
