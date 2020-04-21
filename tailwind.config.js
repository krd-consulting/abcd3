const { colors } = require('tailwindcss/defaultTheme')

module.exports = {
  prefix: 'tw-',
  important: false,
  separator: ':',
  theme: {
  	fontSize: {
		xs: '0.875rem',
		sm: '0.9rem',
		base: '1.125rem',
		lg: '1.25rem',
		xl: '1.5rem',
		'2xl': '1.5rem',
		'3xl': '1.875rem',
		'4xl': '2.25rem',
		'5xl': '3rem',
		'6xl': '4rem',
	},
	extend: {
		spacing: {
        	'72': '18rem',
        	'84': '21rem',
        	'96': '24rem',
		}
	},
	colors: {
		black: colors.black,
		white: colors.white,
		gray: colors.gray,
		red: colors.red,
		yellow: {
			'100': '#FEECC0',
			'200': '#FEDF97',
			'300': '#FED36D',
			'400': '#FEC644',
			'500': ' #feba1b',
			'600': '#E7AA19',
			'700': '#D09917',
			'800': '#A27712',
			'900': '#74550D',
		},
		orange: {
			'100': '#FBE4BB',
			'200': '#F8D28D',
			'300': '#F6C060',
			'400': '#F3AE33',
			'500': '#f19d06',
			'600': '#DC8F06',
			'700': '#B07305',
			'800': '#845604',
			'900': '#583A03',
		},
		green: {
			'100': '#E6ECD8',
			'200': '#C2CF9E',
			'300': '#AABC78',
			'400': '#92A951',
			'500': '#7a972b',
			'600': '#6F8A28',
			'700': '#647C24',
			'800': '#596E20',
			'900': '#4E611C',
		},
		blue: {
			'100': '#9FB6C3',
			'200': '#668BA0',
			'300': '#537C94',
			'400': '#406E88',
			'500': '#2d607d',
			'600': '#295872',
			'700': '#254F67',
			'800': '#21465B',
			'900': '#193545',
		},
		indigo: colors.indigo,
		purple: colors.purple,
	}
  },
  variants: {
    backgroundColor: ['even', 'hover'],
  },
}
