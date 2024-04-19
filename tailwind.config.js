/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            screens: {
                xs: '320px',
                sm: '480px',
                footer: '597px',
                md: '768px',
                lg: '976px',
                xl: '1120px',
                xxl: '1440px',
            },
            borderRadius: {
                '4xl': '2rem',
            },
            opacity: {
                '0': '0',
                '20': '0.2',
                '40': '0.4',
                '60': '0.6',
                '80': '0.8',
                '100': '1',
            },
            flex: {
                'auto1': '0 0 auto'
            },
            scale: {
                "20": '0.20',
                "25": '0.25',
                "30": '0.30',
                "35": '0.35',
            }
        },
    },
    plugins: [],
}
