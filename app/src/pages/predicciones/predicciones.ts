import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams, LoadingController, AlertController, Keyboard } from 'ionic-angular';
import { RestProvider } from '../../providers/rest/rest';
import { GlobalsProvider } from '../../providers/globals/globals';

/**
 * Generated class for the PrediccionesPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-predicciones',
  templateUrl: 'predicciones.html',
})
export class PrediccionesPage {
  public loading;
  partidos: any;
  finales: any;
  indice = 0;
  pestanias = new Array('A','B','C','D','E','F','G','H');
  grupos = new Array();
  resultados = new Array();
  resultadosfinales = new Array();
  completes = new Array();
  modelo;
  fase;

  constructor(public navCtrl: NavController, 
    public navParams: NavParams,
    public restProvider: RestProvider,
    public loadingCtrl: LoadingController,
    public alertCtrl: AlertController,
    public keyboard: Keyboard) {
      this.modelo = this.pestanias[this.indice];
      this.fase = 'grupos';
      this.getUnreadMsgs();
  }

  getUnreadMsgs(){
    let data: Object = {email:GlobalsProvider.mailUser,date:GlobalsProvider.lastMsg};
    this.restProvider.getUnreads(data)
    .then(data => {
      console.log(data);
      if(data["status"] == 1){
        GlobalsProvider.unreadMsgs = data["number"];
      }
    });
  }

  ionViewDidLoad() {
    this.loading = this.loadingCtrl.create({content:'Cargando datos...'});
    this.loading.present();
    let data: Object = {email:GlobalsProvider.mailUser,fase:"grupo"};
    this.restProvider.getPrediccionesUser(data)
    .then(data => {
      if(data["status"] == 1){
        this.partidos = data["predicciones"];
        let count = 1;
        let indx = 0;
        let nullscore = 0;
        let grupo = new Array();
        this.partidos.forEach(element => {
          this.resultados.push(new Object({id:element.id,local:element.prediccionLocal,visitante:element.prediccionVisitante}));
          element.index = indx;
          if(element.prediccionLocal == null || element.prediccionVisitante == null){
            nullscore++;
          }
          grupo.push(element);
          if(count % 6 == 0){
            this.grupos.push(grupo);
            grupo = new Array();
            this.completes.push(nullscore);
            nullscore = 0;
          }
          count++;
          indx++;
        });
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

    
    let datafinales: Object = {email:GlobalsProvider.mailUser,fase:"final"};
    this.restProvider.getPrediccionesUser(datafinales)
    .then(data => {
      this.loading.dismiss();
      if(data["status"] == 1){
        this.finales = data["predicciones"];
        this.finales.forEach(element => {
          this.resultadosfinales.push(new Object({id:element.id,local:element.prediccionLocal,visitante:element.prediccionVisitante}));
        });
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


  hideKeyboard(){
    //this.keyboard.close();
  }

  selectedContent(ev:any){
    ev.target.value = "";
  }

  swipeEvent(event){
    for(let i = 0; i < this.pestanias.length; i++){
      if(this.pestanias[i] == this.modelo){
        this.indice = i;
      }
    }
    if(event.direction == 2){
      if(this.indice < this.pestanias.length-1){
        this.indice++;
      } 
    }
    if(event.direction == 4){
      if(this.indice > 0){
        this.indice--;
      }
    }
    this.modelo = this.pestanias[this.indice];
  }

  sendPredicciones(){
    this.loading = this.loadingCtrl.create({content:'Enviando datos...'});
    this.loading.present();

    let data: Object = {email:GlobalsProvider.mailUser,predicciones:this.resultados};
    this.restProvider.sendPrediccionesUser(data)
    .then(data => {
      //this.loading.dismiss();
      if(data["status"] == 1){
        this.sendFinales();
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

  sendFinales(){
    let data: Object = {email:GlobalsProvider.mailUser,predicciones:this.resultadosfinales};
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

}
