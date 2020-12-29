module.exports = {
    prefix: 'tw-',
    important: 'true',
    purge: [
        './resources/**/*.blade.php',
        './resources/**/**/*.blade.php',
        './resources/**/**/**/*.blade.php',
        './resources/**/**/**/**/*.blade.php',

        './resources/**/*.js',
        './resources/**/**/*.js',
        './resources/**/**/**/*.js',
        './resources/**/**/**/**/*.js',

        './resources/**/*.vue',
        './resources/**/**/*.vue',
        './resources/**/**/**/*.vue',
        './resources/**/**/**/**/*.vue',

    ],
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {},
    },
    variants: {
        extend: {},
    },
    plugins: [],
}
