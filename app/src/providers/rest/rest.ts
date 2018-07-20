import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { GlobalsProvider } from '../globals/globals';

/*
  Generated class for the RestProvider provider.

  See https://angular.io/guide/dependency-injection for more info on providers
  and Angular DI.
*/
@Injectable()
export class RestProvider {
  apiUrl = '[HOST]/kirito/v1';
  headers;


  constructor(public http: HttpClient) {
    this.headers = {
      'Authorization': GlobalsProvider.token
    };
  }

  checkMail(data) {
    return new Promise((resolve, reject) => {
      this.http.post(this.apiUrl+'/user/check', JSON.stringify(data),{
        headers: this.headers
      })
        .subscribe(res => {
          resolve(res);
        }, (err) => {
          reject(err);
        });
    });
  }

  activateUser(data) {
    this.headers = {
      'Authorization': GlobalsProvider.token
    };
    return new Promise((resolve, reject) => {
      this.http.post(this.apiUrl+'/user/activate', JSON.stringify(data),{
        headers: this.headers
      })
        .subscribe(res => {
          resolve(res);
        }, (err) => {
          reject(err);
        });
    });
  }

  getPrediccionesUser(data) {
    this.headers = {
      'Authorization': GlobalsProvider.token
    };
    return new Promise((resolve, reject) => {
      this.http.post(this.apiUrl+'/user/predicciones', JSON.stringify(data),{
        headers: this.headers
      })
        .subscribe(res => {
          resolve(res);
        }, (err) => {
          reject(err);
        });
    });
  }

  sendPrediccionesUser(data) {
    this.headers = {
      'Authorization': GlobalsProvider.token
    };
    return new Promise((resolve, reject) => {
      this.http.post(this.apiUrl+'/user/save', JSON.stringify(data),{
        headers: this.headers
      })
        .subscribe(res => {
          resolve(res);
        }, (err) => {
          reject(err);
        });
    });
  }

  getRanking(data) {
    this.headers = {
      'Authorization': GlobalsProvider.token
    };
    return new Promise((resolve, reject) => {
      this.http.post(this.apiUrl+'/prode/ranking', JSON.stringify(data),{
        headers: this.headers
      })
        .subscribe(res => {
          resolve(res);
        }, (err) => {
          reject(err);
        });
    });
  }

  getStats(data) {
    this.headers = {
      'Authorization': GlobalsProvider.token
    };
    return new Promise((resolve, reject) => {
      this.http.post(this.apiUrl+'/user/stats', JSON.stringify(data),{
        headers: this.headers
      })
        .subscribe(res => {
          resolve(res);
        }, (err) => {
          reject(err);
        });
    });
  }

  getNews(data) {
    this.headers = {
      'Authorization': GlobalsProvider.token
    };
    return new Promise((resolve, reject) => {
      this.http.post(this.apiUrl+'/prode/news', JSON.stringify(data),{
        headers: this.headers
      })
        .subscribe(res => {
          resolve(res);
        }, (err) => {
          reject(err);
        });
    });
  }

  getResultados(data) {
    this.headers = {
      'Authorization': GlobalsProvider.token
    };
    return new Promise((resolve, reject) => {
      this.http.post(this.apiUrl+'/prode/resultados', JSON.stringify(data),{
        headers: this.headers
      })
        .subscribe(res => {
          resolve(res);
        }, (err) => {
          reject(err);
        });
    });
  }

  getVersionApp(data) {
    this.headers = {
      'Authorization': GlobalsProvider.token
    };
    return new Promise((resolve, reject) => {
      this.http.post(this.apiUrl+'/prode/version', JSON.stringify(data),{
        headers: this.headers
      })
        .subscribe(res => {
          resolve(res);
        }, (err) => {
          reject(err);
        });
    });
  }


  getPrediccionesPartido(data) {
    this.headers = {
      'Authorization': GlobalsProvider.token
    };
    return new Promise((resolve, reject) => {
      this.http.post(this.apiUrl+'/prode/prediccionesusers', JSON.stringify(data),{
        headers: this.headers
      })
        .subscribe(res => {
          resolve(res);
        }, (err) => {
          reject(err);
        });
    });
  }

  getPrediccionesToday(data) {
    this.headers = {
      'Authorization': GlobalsProvider.token
    };
    return new Promise((resolve, reject) => {
      this.http.post(this.apiUrl+'/user/today', JSON.stringify(data),{
        headers: this.headers
      })
        .subscribe(res => {
          resolve(res);
        }, (err) => {
          reject(err);
        });
    });
  }

  sendMessage(data) {
    this.headers = {
      'Authorization': GlobalsProvider.token
    };
    return new Promise((resolve, reject) => {
      this.http.post(this.apiUrl+'/user/message', JSON.stringify(data),{
        headers: this.headers
      })
        .subscribe(res => {
          resolve(res);
        }, (err) => {
          reject(err);
        });
    });
  }

  getMessages(data) {
    this.headers = {
      'Authorization': GlobalsProvider.token
    };
    return new Promise((resolve, reject) => {
      this.http.post(this.apiUrl+'/prode/messages', JSON.stringify(data),{
        headers: this.headers
      })
        .subscribe(res => {
          resolve(res);
        }, (err) => {
          reject(err);
        });
    });
  }

  getUnreads(data) {
    this.headers = {
      'Authorization': GlobalsProvider.token
    };
    return new Promise((resolve, reject) => {
      this.http.post(this.apiUrl+'/user/unread', JSON.stringify(data),{
        headers: this.headers
      })
        .subscribe(res => {
          resolve(res);
        }, (err) => {
          reject(err);
        });
    });
  }

}
