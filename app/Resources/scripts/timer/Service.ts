export default class TimerService {
    private minutes: number;

    constructor() {

    }

    setMinutes(minutes: number) {
        this.minutes = minutes;
    }

    getMinutes(): number {
        return this.minutes;
    }

    getMinutesFormatted(): string {
        return this.formatNumber(this.minutes);
    }

    decreaseMinutes() {
        this.minutes--;
    }

    private formatNumber(number: number): string {
        return number < 10 ? '0' + number.toString() : number.toString();
    }
}
