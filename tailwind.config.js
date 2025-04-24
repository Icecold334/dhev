// tailwind.config.js
const colors = ["primary", "secondary", "danger", "success", "warning", "info"];
const shades = [50, 100, 200, 300, 400, 500, 600, 700, 800, 900];
const directions = [
    "m",
    "p",
    "mt",
    "mb",
    "ml",
    "mr",
    "mx",
    "my",
    "pt",
    "pb",
    "pl",
    "pr",
    "px",
    "py",
];
const spacings = Array.from({ length: 97 }, (_, i) => i); // 0 - 96

module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {},
    },
    safelist: [
        // Colors
        ...colors.flatMap((color) =>
            shades.flatMap((shade) => [
                `bg-${color}-${shade}`,
                `text-${color}-${shade}`,
                `border-${color}-${shade}`,
            ])
        ),

        // Spacing utilities
        ...directions.flatMap((dir) =>
            spacings.map((size) => `${dir}-${size}`)
        ),
    ],
    plugins: [],
};
