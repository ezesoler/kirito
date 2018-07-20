import { Injectable } from '@angular/core';

/*
  Generated class for the GlobalsProvider provider.

  See https://angular.io/guide/dependency-injection for more info on providers
  and Angular DI.
*/
@Injectable()
export class GlobalsProvider {
  static mailUser:string;
  static token:string = "0";
  static tfcm:string;
  static versionApp = 9;
  static redirect = "";
  static lastMsg = "2018-06-11 19:26:25";
  static unreadMsgs = 0;

}
