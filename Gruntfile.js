module.exports = function( grunt ) {
	// Project configuration.
	grunt.initConfig( {
		// Package
		pkg: grunt.file.readJSON( 'package.json' ),
		
		// PHPLint
		phplint: {
			options: {
				phpArgs: {
					'-lf': null
				}
			},
			all: [ '**/*.php', '!node_modules/**', '!bower_components/**' ]
		},
		
		// MakePOT
		makepot: {
			target: {
				options: {
					cwd: '',
					domainPath: 'languages',
					type: 'wp-theme',
					exclude: [ 'bower_components/.*', 'node_modules/.*' ],
				}
			}
		},

		// Copy
		copy: {
			main: {
				files: [
					{ // Bootstrap
						expand: true,
						cwd: 'bower_components/bootstrap/dist/',
						src: [ '**' ],
						dest: 'assets/bootstrap'
					},
				]
			}
		},
		
		// Concat
		concat: {
			css: {
				src: [ 'src/orbis/css/orbis.css' ],
				dest: 'assets/orbis/css/orbis.css'
			},
			js: {
				src: [ 'src/orbis/js/orbis.js' ],
				dest: 'assets/orbis/js/orbis.js'
			}
		},

		// CSS min
		cssmin: {
			combine: {
				files: {
					'assets/orbis/css/orbis.min.css': [ 'assets/orbis/css/orbis.css' ]
				}
			}
		},
		
		// Uglify
		uglify: {
			combine: {
				files: {
					'assets/orbis/js/orbis.min.js': [ 'assets/orbis/js/orbis.js' ]
				}
			}
		},

		// Image min
		imagemin: {
			dynamic: {
				files: [
					{ // Orbis
						expand: true,
						cwd: 'src/orbis/images',
						src: [ '**/*.{png,jpg,gif}' ],
						dest: 'assets/orbis/images'
					}
				]
			}
		}
	} );

	grunt.loadNpmTasks( 'grunt-phplint' );
	grunt.loadNpmTasks( 'grunt-wp-i18n' );
	grunt.loadNpmTasks( 'grunt-contrib-copy' );
	grunt.loadNpmTasks( 'grunt-contrib-concat' );
	grunt.loadNpmTasks( 'grunt-contrib-cssmin' );
	grunt.loadNpmTasks( 'grunt-contrib-uglify' );
	grunt.loadNpmTasks( 'grunt-contrib-imagemin' );

	// Default task(s).
	grunt.registerTask( 'default', [ 'phplint', 'copy', 'concat', 'cssmin', 'uglify', 'imagemin' ] );
	grunt.registerTask( 'pot', [ 'makepot' ] );
};
