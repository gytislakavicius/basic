///<amd-dependency path='timer/Module'/>
import * as angular from 'angular';

class Basic {
    constructor() {
        angular
            .module('basic', [
                'basic.timer'
            ]);
    }
}

export default new Basic();
