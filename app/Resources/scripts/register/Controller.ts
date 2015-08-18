export default class RegisterController {
    username: string;
    private http: angular.IHttpService;

    constructor($http: angular.IHttpService) {
        this.http = $http;
    }

    submit(event: Event) {
        event.preventDefault();

        this.http
            .post('/sign-up', {username: this.username})
            .success(function (data) {
                console.log(data);
            });
    }
}
