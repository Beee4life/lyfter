'use strict';

module.exports = function(grunt){

    const sass = require('node-sass');

    // Load grunt tasks automatically
    require('jit-grunt')(grunt);

    // Configurable paths
    var config = {
        tmp: '.tmp',
        base: './src',
        theme_dest: 'web/app/themes/petsecur/assets',
        plugin_dest: '<%= config.theme_dest %>/css/plugins.min.css',
        css_dest: '<%= config.theme_dest %>/css/style.min.css',
        admin_dest: '<%= config.theme_dest %>/css/admin.min.css'
    };

    grunt.initConfig({

        // Project settings
        config: config,

        // Compiles Sass to CSS and generates necessary files if requested
        sass: {
            options: {
                implementation: sass,
                sourceMap: true
            },
            dist: {
                files: {
                    '<%= config.tmp %>/styles/style.css': '<%= config.base %>/scss/style.scss',
                    '<%= config.tmp %>/styles/plugins.css': '<%= config.base %>/scss/plugins.scss',
                    '<%= config.tmp %>/styles/admin.css': '<%= config.base %>/scss/admin.scss'
                }
            }
        },

        // Add vendor prefixed styles
        postcss: {
            options: {
                map: true
            },
            dist: {
                files: [{
                    expand: true,
                    cwd: '<%= config.tmp %>/styles/',
                    src: '{,**/}*.css',
                    dest: '<%= config.tmp %>/styles/'
                }]
            }
        },

        cssmin: {
            dist: {
                options: {
                    keepBreaks: true
                },
                files: {
                    '<%= config.css_dest %>': '<%= config.tmp %>/styles/style.css',
                    '<%= config.plugin_dest %>': '<%= config.tmp %>/styles/plugins.css',
                    '<%= config.admin_dest %>': '<%= config.tmp %>/styles/admin.css'
                }
            }
        },

        // COOL TASKS ==============================================================
        watch: {
            scss: {
                files: ['<%= config.base %>/**/*.{scss,sass}'],
                tasks: ['sass:dist', 'postcss', 'cssmin']
            },
            js: {
                files: [
                    '<%= config.base %>/js/**/*.js',
                    '!<%= config.base %>/scripts/vendor/{,**/}*.js',
                    '!<%= config.base %>/node_modules/{,**/}*.js'
                ],
                tasks: ['uglify:my_target']
            },
            livereload: {
                options: {
                    livereload: 35729
                },
                files: [
                    '<%= config.css_dest %>',
                    '<%= config.plugin_dest %>',
                    '<%= config.admin_dest %>'
                ]
            }
        },

        concurrent: {
            options: {
                logConcurrentOutput: true
            },
            tasks: ['sass:dist', 'postcss', 'cssmin', 'watch']
        },

        uglify: {
            my_target: {
                files: {
                    './<%= config.theme_dest %>/js/main.min.js': [ '<%= config.base %>/js/functions/*.js', '<%= config.base %>/js/main.js'],
                    './<%= config.theme_dest %>/js/admin.min.js': [ '<%= config.base %>/js/admin/*.js', '<%= config.base %>/js/admin.js'],
                }
            }
        }

    });

    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-postcss');
    grunt.loadNpmTasks('grunt-concurrent');
    grunt.loadNpmTasks('grunt-contrib-clean');

    grunt.registerTask('default', ['build', 'concurrent', 'uglify']);
    grunt.registerTask('build', ['sass:dist', 'postcss', 'cssmin', 'uglify']);

};
