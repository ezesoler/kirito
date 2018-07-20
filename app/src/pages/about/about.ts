import { Component, ViewChild } from '@angular/core';
import { IonicPage, NavController, NavParams } from 'ionic-angular';
import { GlobalsProvider } from '../../providers/globals/globals';


/**
 * Generated class for the AboutPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-about',
  templateUrl: 'about.html',
})
export class AboutPage {
  tongo = "https://www.youtube.com/watch?v=veM_D3fqZ2A";
  counti = 0;
  countd = 0;
  countm = 0;
  versionApp = GlobalsProvider.versionApp;
  @ViewChild("audio") audio;
  constructor(public navCtrl: NavController, public navParams: NavParams) {
  }

  ionViewDidLoad() {
    console.log('ionViewDidLoad AboutPage');
  }

  easteregg(event){
    if(event.direction == 2){
      this.counti++;
      if(this.counti == 4){
        this.counti = 0;
      }
      this.countd = 0;
    }if(event.direction == 4 && this.counti == 3){
      this.countd++;
      if(this.countd == 3){
        this.countd = 0;
      }
    }if(this.counti == 3 && this.countd == 2){
      window.open(this.tongo, '_system');
    }
  }

  mmlpqtp(){
    this.countm++
    if(this.countm == 5){
      this.audio.nativeElement.play();
    }
  }

}
