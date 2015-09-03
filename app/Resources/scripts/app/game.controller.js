/**
 *
 * @param gameFactory
 */
var gameController = function(gameFactory, $timeout) {
    var vm = this;

    vm.dataLoaded = false;
    vm.answerSubmited = false;
    vm.timerStopped = false;
    vm.timerStarted = false;

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

    /**
     *
     * @param question
     * @param answer
     */
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

    var currentTime = null;
    var timeLeft = null;

    vm.countDownTimer = function() {
        $timeout(function() {
            currentTime = new Date();
            secondsLeft = vm.activeQuestion.activeTo - Math.floor(currentTime.getTime() / 1000);

            vm.hours = Math.floor(secondsLeft / (60 * 60));
            vm.minutes = Math.floor((secondsLeft % (60 * 60)) / 60);
            vm.seconds = Math.floor(secondsLeft % vm.minutes);

            if (Math.floor(currentTime.getTime() / 1000) == vm.activeQuestion.activeTo) {
                vm.activeQuestion = null;
                vm.timerStopped = true;
            }

            vm.countDownTimer();
        }, 1000);
    };

    vm.countDownTimer();

    /**
     *
     * @param questions
     */
    function getActiveQuestion(questions) {
        questions.map(function(question) {
            if (question.isActive) {
                vm.activeQuestion = question;
                vm.timerStarted = true;
            }
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