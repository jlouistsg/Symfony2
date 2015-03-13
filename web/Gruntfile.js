module.exports = function(grunt) {
	var path = require("path");

	grunt.loadNpmTasks('grunt-contrib-uglify'); // Minifier/Concaténer les fichiers JS
	grunt.loadNpmTasks('grunt-contrib-cssmin'); // Minifier/Concaténer les fichier CSS
	grunt.loadNpmTasks('grunt-contrib-jshint'); // Compilateur JS
	grunt.loadNpmTasks('grunt-contrib-watch'); 	// Watcher d'événement
	
	var jsDist = '../src/Esgi/BlogBundle/Resources/js/built/_built.js';
    var jsSrc = ['../src/Esgi/BlogBundle/Resources/js/**/*.js', '!' + jsDist, '!../src/Esgi/BlogBundle/Resources/js/vendor/**/*.js', '!../src/Esgi/BlogBundle/Resources/js/bootstrap.min.js'];

	var cssDist = '../src/Esgi/BlogBundle/Resources/css/built/_built.css';
    var cssSrc = ['../src/Esgi/BlogBundle/Resources/css/**/*.css', '!' + cssDist];
	
    // Configuration de Grunt
    grunt.initConfig({
    	jshint: {
    		all: ['Gruntfile.js', jsSrc]
		},
		uglify: {
		    options: {
		        separator: ';',
		        mangle: false
		    },
		    compile: {
		        src: jsSrc,
		        dest: jsDist
		    }
		},
		cssmin: {
            compile: {
                src: cssSrc,
                dest: cssDist
            }
        },
		watch: {
		    scripts: {
		        files: ['Gruntfile.js', jsSrc, cssSrc],
		        tasks: ['scripts']
		    }
		}
    });

    grunt.registerTask('default', ['scripts', 'watch']);
	grunt.registerTask('scripts', ['jshint', 'uglify:compile', 'cssmin:compile']);
};