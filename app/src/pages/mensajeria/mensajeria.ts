import { Component, ViewChild } from '@angular/core';
import { IonicPage, NavController, NavParams, LoadingController, AlertController } from 'ionic-angular';
import { RestProvider } from '../../providers/rest/rest';
import { GlobalsProvider } from '../../providers/globals/globals';
import { Storage } from '@ionic/storage';

/**
 * Generated class for the MensajeriaPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-mensajeria',
  templateUrl: 'mensajeria.html',
})
export class MensajeriaPage {
  mensaje;
  mensajes: any;
  mailUser = GlobalsProvider.mailUser;
  @ViewChild('content') content:any;
  public loading;
  mymsg = false;
  constructor(public navCtrl: NavController,
    public navParams: NavParams,
    public restProvider: RestProvider,
    public loadingCtrl: LoadingController,
    public alertCtrl: AlertController,
    public storage: Storage) {
  }

  ionViewDidLoad() {
    this.getMensajes();
  }

  getMensajes(){
    let data: Object = {email:GlobalsProvider.mailUser};
    this.restProvider.getMessages(data)
    .then(data => {
      if(data["status"] == 1){
        this.mensajes = data["messages"];
        if(this.mymsg){
          setTimeout(()=>{this.content.scrollToBottom();},200);
          setTimeout(()=>{this.saveLasMsg();},200);
        }else{
          setTimeout(()=>{this.scrollToElement(GlobalsProvider.lastMsg);},200); 
          setTimeout(()=>{this.saveLasMsg();},1000);
        } 
      }else{
        let alert = this.alertCtrl.create({
          title: 'Error!',
          subTitle: 'Algo pasó y no se puedo traer los mensajes.',
          buttons: ['Como si me importaran']
        });
        alert.present();
      }
    });
  }

  sendMensaje(){
    let alert;
    console.log("pasa");
    if((this.mensaje != "") && (this.mensaje != null)){
      console.log("pasa2");
      this.loading = this.loadingCtrl.create({content:'Enviando mensaje...'});
      this.loading.present();
      let data: Object = {email:GlobalsProvider.mailUser,message:this.mensaje};
      this.restProvider.sendMessage(data)
      .then(data => {
        this.loading.dismiss();
        if(data["status"] == 1){
          this.mensaje = "";
          this.mymsg = true;
          this.getMensajes();
        }else{
          alert = this.alertCtrl.create({
            title: 'Error!',
            subTitle: 'No se puedo enviar el mensaje.',
            buttons: ['Alta bosta esta app']
          });
          alert.present();
        }
      });
    }
  }

  scrollToElement(id) { 
    var el = document.getElementById(id);
    var rect = el.getBoundingClientRect();
    this.content.scrollTo(0, rect.top, 800);
  }

  saveLasMsg(){
    GlobalsProvider.lastMsg = this.mensajes[this.mensajes.length-1].idmsg;
    this.storage.set('lastmsg', GlobalsProvider.lastMsg);
  }
  

}
