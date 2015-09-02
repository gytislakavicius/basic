/**
 * Base module
 */
angular.module('game', [])
    .controller('gameController', gameController)
    .factory('gameFactory', gameService);