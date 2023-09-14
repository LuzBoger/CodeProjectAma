/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["PageHTML/Facturation.html.php", "FonctionPHP/HeaderGesture.php",
    "PageHTML/Générale.html.php", "PageHTML/Accueil.html.php", 'Php/TableauGénérale.php', "PageHTML/SousPageHTML/Horaire.html.php",
    "test.html.php"],
  theme: {
    extend: {
      colors: {
        'AmaGreen': '#DEF4DF',
        'AmaBlue': '#494566',
        'HoverGreen': '#BED4BF',
        'AmaBordure': '#6f78a1',
        'jotaro': "#639976",
        'dio': '#b22222',
        'colorWrite': '#051313',
        'gray': "#808080",

      },
      width: {
        '13%': '13%',
        '1px': '1px',

      },
      borderWidth: {
        '20': '20px',

      },
      height: {
        '1px': '1px',

      }
    },

  },
  plugins: [],
}