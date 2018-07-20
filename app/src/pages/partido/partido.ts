import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams, LoadingController, AlertController } from 'ionic-angular';
import { RestProvider } from '../../providers/rest/rest';
import { GlobalsProvider } from '../../providers/globals/globals';

/**
 * Generated class for the PartidoPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-partido',
  templateUrl: 'partido.html',
})
export class PartidoPage {
  public loading;
  idPartido;
  infoPartido: any;
  predicciones: any;
  partidojugado = 0;
  constructor(public navCtrl: NavController,
    public navParams: NavParams,
    public loadingCtrl: LoadingController,
    public restProvider: RestProvider,
    public alertCtrl: AlertController) {
    this.idPartido = navParams.get("idPartido");
  }

  ionViewDidLoad() {
    this.loading = this.loadingCtrl.create({content:'Cargando datos...'});
    this.loading.present();
    let data: Object = {email:GlobalsProvider.mailUser,idPartido:this.idPartido};
    this.restProvider.getPrediccionesPartido(data)
    .then(data => {
      this.loading.dismiss();
      if(data["status"] == 1){
        this.infoPartido = data["partido"];
        this.predicciones = data["predicciones"];
        this.partidojugado = Number(this.infoPartido.jugado);
        this.predicciones.forEach(element => {
          element["result"] = 0;
          if(element.email == GlobalsProvider.mailUser){
            element.nombre = "yo";
          }
            if((this.infoPartido.marcadorLocal == element.marcadorLocal) && (this.infoPartido.marcadorVisitante == element.marcadorVisitante)){
              element["result"] = 1;
            }else{
              if((this.infoPartido.marcadorLocal > this.infoPartido.marcadorVisitante) && (element.marcadorLocal > element.marcadorVisitante)){
                element["result"] = 2;
              }else if((this.infoPartido.marcadorLocal < this.infoPartido.marcadorVisitante) && (element.marcadorLocal < element.marcadorVisitante)){
                element["result"] = 2;
              }else if((this.infoPartido.marcadorLocal == this.infoPartido.marcadorVisitante) && (element.marcadorLocal == element.marcadorVisitante)){
                element["result"] = 2;
              }
            }
        });
        this.predicciones = this.shortJSON(this.predicciones);
      }else{
        let alert = this.alertCtrl.create({
          title: 'Error!',
          subTitle: 'Algo pasó y no se puedo traer las predicciones del partido.',
          buttons: ['Y bueno, será la próxima']
        });
        alert.present();
      }
    });
  }

  shortJSON(data){
    let first = data[0];
    for(var i = 0;i < data.length; i++){
      if(data[i].nombre == "yo"){
        data[0] = data[i];
        data[i] = first;
      }
    }
    return data;
  }

}
