import { Component, ViewChild } from '@angular/core';
import { IonicPage, NavController, NavParams, LoadingController, AlertController } from 'ionic-angular';
import { RestProvider } from '../../providers/rest/rest';
import { GlobalsProvider } from '../../providers/globals/globals';
import { PartidoPage } from '../partido/partido';

/**
 * Generated class for the ResultadosPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-resultados',
  templateUrl: 'resultados.html',
})
export class ResultadosPage {
  public loading;
  resultados: any;
  @ViewChild('content') content:any;

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
    this.restProvider.getResultados(data)
    .then(data => {
      this.loading.dismiss();
      if(data["status"] == 1){
        this.resultados = data["resultados"];
        if(this.resultados.length > 0){
          this.resultados.forEach(element => {
            if(element.prediccionLocal == "-1"){
              element.prediccionLocal = "-";
            }
            if(element.prediccionVisitante == "-1"){
              element.prediccionVisitante = "-";
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
          setTimeout(()=>{this.content.scrollToBottom();},200); 
        }
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
