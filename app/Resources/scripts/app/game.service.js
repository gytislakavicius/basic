/**
 *
 * @param $http
 * @returns {{}}
 */
var gameService = function($http) {
    /**
     *
     * @type {{}}
     */
    var game = {};

    /**
     *
     * @type {string}
     */
    var data_api = '/game';

    /**
     *
     * @type {string}
     */
    var answer_submit_api = '/game/answer/';

    /**
     *
     * @returns {*}
     */
    game.get = function() {
        return $http.get(data_api);
    };

    /**
     *
     * @param q
     * @param a
     * @returns {*}
     */
    game.send = function(q, a) {
        return $http.get(answer_submit_api + q + '/' + a);
    };

    return game;
};

gameService.$inject = ['$http'];