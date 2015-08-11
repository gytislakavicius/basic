///<amd-dependency path='register/Module'/>
import * as angular from 'angular';

class BasicRegister {
    constructor() {
        angular
            .module('basicRegister', [
               'basic.register'
            ]);
    }
}

export default new BasicRegister();
