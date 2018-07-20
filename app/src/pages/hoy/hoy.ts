import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams, LoadingController, AlertController } from 'ionic-angular';
import { RestProvider } from '../../providers/rest/rest';
import { GlobalsProvider } from '../../providers/globals/globals';
import { PartidoPage } from '../partido/partido';

/**
 * Generated class for the HoyPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-hoy',
  templateUrl: 'hoy.html',
})
export class HoyPage {
  public loading;
  partidos_hoy: any;
  partidos_maniana: any;
  resultados = new Array();
  dia;
  constructor(public navCtrl: NavController, 
    public navParams: NavParams,
    public restProvider: RestProvider,
    public loadingCtrl: LoadingController,
    public alertCtrl: AlertController,) {
      this.dia = 'hoy';
  }

  ionViewDidLoad() {
      this.loading = this.loadingCtrl.create({content:'Cargando datos...'});
      this.loading.present();
      let data: Object = {email:GlobalsProvider.mailUser,fase:"grupo"};
      this.restProvider.getPrediccionesToday(data)
      .then(data => {
        if(data["status"] == 1){
          this.partidos_hoy = data["today"];
          this.partidos_maniana = data["tomorrow"];
          let indx = 0;
          let d = new Date();
          this.partidos_hoy.forEach(element => {
            let hp = element.hora.split(":");
            if((hp[0] == d.getHours()) || (Number(hp[0])+1 == d.getHours())){
              element.vivo = 1;
            }else{
              element.vivo = 0;
            }
            element["result"] = 0;
            if(!isNaN(element.prediccionVisitante) && !isNaN(element.prediccionLocal)){
              if((element.marcadorLocal == element.prediccionLocal) && (element.marcadorVisitante == element.prediccionVisitante)){
                element["result"] = 1;
              }else{
                if((element.marcadorLocal > element.marcadorVisitante) && (element.prediccionLocal > element.prediccionVisitante)){
                  element["result"] = 2;
                }else if((element.marcadorLocal < element.marcadorVisitante) && (element.prediccionLocal < element.prediccionVisitante)){
                  element["result"] = 2;
                }else if((element.marcadorLocal == element.marcadorVisitante) && (element.prediccionLocal == element.prediccionVisitante)){
                  element["result"] = 2;
                }
              }
            }
          });
          this.partidos_maniana.forEach(element => {
            this.resultados.push(new Object({id:element.id,local:element.prediccionLocal,visitante:element.prediccionVisitante}));
            element.index = indx;
            indx++;
          });
          this.loading.dismiss();
        }else{
          this.loading.dismiss();
          let alert = this.alertCtrl.create({
            title: 'Error!',
            subTitle: 'Algo pasó y no se puedieron traer tus predicciones.',
            buttons: ['Bueno, y que querés que te responda?']
          });
          alert.present();
        }
      });
    }


    sendPredicciones(){
      this.loading = this.loadingCtrl.create({content:'Enviando datos...'});
      this.loading.present();
  
      let data: Object = {email:GlobalsProvider.mailUser,predicciones:this.resultados};
      this.restProvider.sendPrediccionesUser(data)
      .then(data => {
        this.loading.dismiss();
        if(data["status"] == 1){
          let alert = this.alertCtrl.create({
            subTitle: 'Los datos fueron guardados correctamente',
            buttons: ['Mató mil']
          });
          alert.present();
        }else{
          let alert = this.alertCtrl.create({
            title: 'Error!',
            subTitle: 'Algo pasó y no se puedieron traer tus predicciones.',
            buttons: ['Bueno, y que querés que te responda?']
          });
          alert.present();
        }
      });
    }

    itemSelected(idPartido){
      this.navCtrl.push(PartidoPage,{idPartido:idPartido});
    }
  

}
