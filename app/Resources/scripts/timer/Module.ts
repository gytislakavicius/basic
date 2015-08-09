import * as angular from 'angular';
import TimerCtrl from './Controller';
import TimerService from './Service';

class TimerModule {
    constructor() {
        angular
            .module('basic.timer', [])
            .service('TimerService', TimerService)
            .controller('TimerCtrl', [
                '$timeout',
                'TimerService',
                TimerCtrl
            ]);
    }
}

export default new TimerModule();
