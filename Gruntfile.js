module.exports = function(grunt) {
    'use strict';

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
        concat: {
            options: {
                separator: ';'
            },
            dist: {
                src: ['app/Resources/scripts/angular.min.js', 'app/Resources/scripts/app.js'],
                dest: 'web/scripts/app.js'
            }
        },
        watch: {
            styles: {
                files: ['app/Resources/styles/**/*.less'],
                tasks: ['less'],
                options: {
                    spawn: false
                }
            },
            scripts: {
                files: ['app/Resources/scripts/**/*.js'],
                tasks: ['concat'],
                options: {
                    spawn: false
                }
            }
        }
    });

    grunt.registerTask('default', ['less', 'concat']);
};
