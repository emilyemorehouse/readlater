module.exports = function (grunt) {

	"use strict";

	var srcPath = 'app/Resources/bower';
	var dstPath = 'web';
	var resourcesPath = 'app/Resources/';

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		bowercopy: {
			options: {
				srcPrefix: srcPath,
				destPrefix: dstPath
			},
			scripts: {
				files: {
					'js/jquery.min.map': 'jquery/dist/jquery.min.map'
				}
			},
			fonts: {
				files: {
					'fonts': 'components-font-awesome/fonts/*'
				}
			}
		},

		concat: {
			options: {
				stripBanners: true
			},
			js: {
				src: [
					srcPath + '/jquery/dist/jquery.min.js',
					srcPath + '/bootstrap/dist/js/bootstrap.min.js',
					resourcesPath + '/js/*.js'
				],
				dest: dstPath + '/js/main.js'
			},
			css: {
				src: [
					resourcesPath + '/css/*.css'
				],
				dest: dstPath + '/css/main.css'
			}
		},

		watch: {
			styles: {
				files: ['app/Resources/less/**/*.less'],
				tasks: 'styles'
			},
			js: {
				files: [resourcesPath + '/js/*.js'],
				tasks: 'scripts'
			}
		},

		less: {
			dist: {
				files: [
					{
						expand: true,
						cwd: 'app/Resources/less/',
						src: ['main.less'],
						dest: resourcesPath + '/css/',
						ext: '.css'
					}
				]
			}
		},

		cssmin: {
			options: {
				keepSpecialComments: 0,
				rebase: false
			},
			bundled: {
				src: dstPath + '/css/main.css',
				dest: dstPath + '/css/main.min.css'
			}
		},

		uglify: {
			js: {
				files: {
					'web/js/main.min.js': [dstPath + '/js/main.js']
				}
			}
		},

		strip: {
			main: {
				src: dstPath + '/js/main.min.js',
				dest: dstPath + '/js/main.min.js'
			}
		}
	});

	// Default task
	grunt.registerTask('deploy', [
		'bowercopy',
		'less',
		'concat',
		'cssmin',
		'uglify',
		'strip'
	]);

	grunt.registerTask('styles', [
		'less',
		'concat',
		'cssmin'
	]);

	grunt.registerTask('scripts', [
		'concat',
		'uglify',
		'strip'
	]);

	require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);
};
