var app = angular.module('game', []);

app.controller('questionController', function(questionFactory) {
    var vm = this;

    vm.answerSubmited = false;
    vm.answerData = null;

    getQuestion();

    /**
     * Public functions
     */

    vm.submitAnswer = function() {
        vm.answerSubmited = true;
    };

    vm.selectAnswer = function(answer) {
        vm.answerData = answer;
    };

    /**
     * Private functions
     */

    function getQuestion() {
        vm.question = questionFactory.get();
    }

    function confirmSubmit(answer) {
        alert(questionFactory.post(answer).response);
    }
});

app.factory('questionFactory', function ($http) {
    var question = {};
    //var endpoint_uri = '/';

    question.get = function() {
        //return $http.get(endpoint_uri);

        return {
            title: 'Kokį automobilį nemuno žiede vairuoja P.Insoda?',
            answers: [
                {
                    id: 0,
                    title: 'Žiauriai greitą dvirką'
                },
                {
                    id: 1,
                    title: 'Mitsubishi Lancer Evo'
                },
                {
                    id: 2,
                    title: 'Subaru Impreza'
                },
                {
                    id: 3,
                    title: 'Porsche 911'
                }
            ]
        }
    };

    question.post = function(data) {
        //return $http.post(endpoint_uri, data);

        return {
            response: data
        }
    };

    return question;
});