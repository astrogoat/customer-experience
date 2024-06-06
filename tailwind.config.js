/** @type {import('tailwindcss').Config} */

module.exports = {
    prefix: 'cx-',
    darkMode: false, // or 'media' or 'class',
    content: [
        './resources/views/components/**/*.blade.php',
        './resources/**/*.js',
    ],
}
