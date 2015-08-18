import * as angular from 'angular';
import RegisterCtrl from './Controller';

class RegisterModule {
    constructor() {
        angular
            .module('basic.register', [])
            .controller('RegisterCtrl', ['$http', RegisterCtrl]);
    }
}

export default new RegisterModule();
