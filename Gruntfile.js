module.exports = function(grunt) {

	// Project configuration.
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		uglify: {
			options: {
				mangle: false
			},
			my_target: {
				files: {
					'js/main.min.js': ['js/main.js'],
					'js/plugins.min.js': ['js/plugins.js']
				}
			}
		},
		svgstore: {
			options: {
				prefix : 'icon-', // This will prefix each ID
				svg: {
					viewBox : '0 0 100 100',
					xmlns: 'http://www.w3.org/2000/svg',
					style: "display: none;"
				}
			},
			default: {
				files: {
					"inc/svg-defs.php": ["svg/*.svg"]
				}
			},
		},
		sass: {
			dist: {
				options: {
					style: 'compressed'
				},
				files: {
					'css/main.css': 'scss/main.scss'
				}
			}
		},
		watch: {
			options: {
				livereload: 1337,
			},
			files: ['scss/*','js/*','svg/*','images/*'],
			tasks: 'default',
		},
	});

	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-svgstore');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-watch');

	// Default task(s).
	grunt.registerTask('default', ['svgstore','sass','uglify']);

	// grunt.event.on('watch', function(action, filepath, target) {
	//   grunt.log.writeln(target + ': ' + filepath + ' has ' + action);
	// });

};
