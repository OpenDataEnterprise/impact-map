module.exports = {
	del: ['dist/**'],
    dist: 'dist',
	stylus: {
		'watch': 'src/app/css/**/*.styl',
		'src': 'src/app/css/app.styl',
		'devOut': 'src/app/css',
        'buildOut': 'build/app/css'
	},
    jade: {
        'watch': 'src/app/templates/**/*.jade',
        'src': 'src/app/templates/app.jade',
        'devOut': 'src/app/templates',
        'buildOut': 'build/app/templates'
    },
    jsx:  {
        'watch': 'src/app/widgets/jsx/**/*.jsx',
        'src': 'src/app/widgets/jsx/**/*.jsx',
        'devOut': 'src/app/widgets/',
        'buildOut': 'build/app/widgets'

    }
};