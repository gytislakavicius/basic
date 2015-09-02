/**
 *
 * @param gameFactory
 */
var gameController = function(gameFactory, $timeout) {
    var vm = this;

    vm.dataLoaded = false;
    vm.answerSubmited = false;

    vm.data = null;
    vm.activeQuestion = null;
    vm.selectedAnswer = null;

    getData();

    /**
     *
     * @param answer
     */
    vm.selectAnswer = function(answer) {
        vm.selectedAnswer = answer;
    };

    /**
     *
     * @param answer
     * @returns {boolean}
     */
    vm.isSelected = function(answer) {
        return answer === vm.selectedAnswer;
    };

    vm.confirmAnswer = function(question, answer) {
        gameFactory.send(question, answer).then(function(response) {
            if (response.status !== 200)
                return null;

            vm.activeQuestion = null;
            vm.answerSubmited = false;
        })
    };

    vm.submitAnswer = function() {
        vm.answerSubmited = true;
    };

    vm.submitCancel = function() {
        vm.answerSubmited = false;
    };

    /**
     *
     * @param questions
     */
    function getActiveQuestion(questions) {
        questions.map(function(question) {
            if (question.isActive)
                vm.activeQuestion = question;
        });
    }

    function getData() {
        gameFactory.get().then(function(response) {
            if (response.status !== 200)
                return null;

            getActiveQuestion(response.data.questions);

            vm.data = response.data;
            vm.dataLoaded = true;

            return response.data;
        });
    }
};

gameController.$inject = ['gameFactory', '$timeout'];