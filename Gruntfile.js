module.exports = function(grunt) {
    'use strict';

    var path = require('path');

    require('jit-grunt')(grunt);

    grunt.initConfig({
        less: {
            compile: {
                options: {
                    compress: true,
                    optimization: 2,
                    yuicompress: true
                },
                files: {
                    'web/css/style.css': 'app/Resources/styles/style.less'
                }
            }
        },
        requirejs: {
            basic: {
                options: {
                    baseUrl: 'web/build-script',
                    out: 'web/js/basic.js',
                    name: 'basic',
                    optimize: '<%= grunt.config.get("requireJsOptimizer") %>',
                    paths: {
                        'angular': path.resolve() + '/node_modules/angular/angular.min'
                    },
                    shim: {
                        'angular': {
                            exports: 'angular'
                        }
                    },
                    skipSemiColonInsertion: true,
                    wrapShim: true,
                    useStrict: true
                }
            },
            basicRegister: {
                options: {
                    baseUrl: 'web/build-script',
                    out: 'web/js/basicRegister.js',
                    name: 'basicRegister',
                    optimize: '<%= grunt.config.get("requireJsOptimizer") %>',
                    paths: {
                        'angular': path.resolve() + '/node_modules/angular/angular.min'
                    },
                    shim: {
                        'angular': {
                            exports: 'angular'
                        }
                    },
                    skipSemiColonInsertion: true,
                    wrapShim: true,
                    useStrict: true
                }
            }
        },
        ts: {
            dev: {
                options: {
                    fast: 'never',
                    module: 'amd',
                    sourceMap: false
                },
                outDir: 'web/build-script',
                reference: 'typings/bundle.d.ts',
                src: ['typings/bundle.d.ts', 'app/Resources/scripts/**/*.ts'],
                target: 'es5'
            }
        }
    });

    grunt.config.set('requireJsOptimizer', 'none');

    grunt.registerTask('default', ['less', 'ts', 'requirejs']);
    grunt.registerTask('scripts', ['ts', 'requirejs']);
}
