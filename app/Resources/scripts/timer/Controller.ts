import TimerService from './Service';

export default class TimerController {
    private t: number;
    private timer: TimerService;
    x: string = '00';

    constructor($timeout, timer: TimerService) {
        this.timer = timer;
        this.timer.setMinutes(15);
        this.x = this.timer.getMinutesFormatted();

        this.t = this.countdown($timeout);
    }

    private countdown($timeout): number {
        return $timeout(() => {
            this.timer.decreaseMinutes();

            if (this.timer.getMinutes() === 0) {
                $timeout.cancel(this.t);
            } else {
                this.countdown($timeout);
            }

            this.x = this.timer.getMinutesFormatted();
        }, 1000);
    }
}
