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
			all: [ '**/*.php' ]
		},
		
		// MakePOT
		makepot: {
			target: {
				options: {
					cwd: '',
					domainPath: 'languages',
					type: 'wp-theme'
				}
			}
		},

		// Concat
		concat: {
			css: {
				src: [ 'src/css/orbis.css' ],
				dest: 'assets/css/orbis.css'
			},
			js: {
				src: [ 'src/js/orbis.js' ],
				dest: 'assets/js/orbis.js'
			}
		},

		// CSS min
		cssmin: {
			combine: {
				files: {
					'assets/css/orbis.min.css': [ 'assets/css/orbis.css' ]
				}
			}
		},
		
		// Uglify
		uglify: {
			combine: {
				files: {
					'assets/js/orbis.min.js': [ 'assets/js/orbis.js' ]
				}
			}
		}

	} );

	grunt.loadNpmTasks( 'grunt-phplint' );
	grunt.loadNpmTasks( 'grunt-wp-i18n' );
	grunt.loadNpmTasks( 'grunt-contrib-concat' );
	grunt.loadNpmTasks( 'grunt-contrib-cssmin' );
	grunt.loadNpmTasks( 'grunt-contrib-uglify' );

	// Default task(s).
	grunt.registerTask( 'default', [ 'phplint', 'makepot', 'concat', 'cssmin', 'uglify' ] );
};
