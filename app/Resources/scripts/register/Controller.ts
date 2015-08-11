var $http: angular.IHttpService;

export default class RegisterController {
    username: string;

    constructor() {

    }

    submit(event: Event) {
        event.preventDefault();

        $http.post('/register', {username: this.username});
    }
}
