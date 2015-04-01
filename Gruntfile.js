module.exports = function(grunt) {
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		sass: {
			options: {},
			dev: {
				files: {
					'./style.css': 'css/style.scss',
					'css/style.css': 'css/style.scss'
				},
				options: {
					outputStyle: 'nested'
				}
			},
			build: {
				files: {
					'./style.css': 'css/style.scss',
				},
				options: {
					outputStyle: 'compressed'
				}
			}
		},
		/*autoprefixer: {
			options: {},
			dev: {
				src: './style.css',
				dest: './style.css'
			}
		},*/
		watch: {
			compile: {
				files: ['css/**/*.scss'],
				tasks: ['compile']
			},
		},
		uglify: {
		    options: {
		      mangle: false
		    },
		    build: {
		      files: {
		        'js/min/cocoricoportfolio.min.js': ['js/cocoricoportfolio.js']

		      }
		    }
		},
		copy: {
			build: {
				expand: true,
				src: ['**', '!.sass-cache', '!cocorico-portfolio/', '!node_modules/**', '!Gruntfile.js', '!README.md', '!LICENSE', '!package.json'],
				dest: 'cocorico-portfolio/',
			}
		}
	});

	grunt.loadNpmTasks('grunt-sass');
	grunt.loadNpmTasks('grunt-autoprefixer');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-contrib-uglify');

	grunt.registerTask('compile', ['sass:dev', 'uglify:build']);
	grunt.registerTask('build', ['sass:dev', 'sass:build', 'uglify:build', 'copy:build']);
};
