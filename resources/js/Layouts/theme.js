export const theme = {
  sidebar: {
    width: 280,
    textColor: '#3f3f46',             // Zinc-700: Rich stone grey, highly readable
    textSize: 16,
    backgroundColor: '#fafafa',       // Zinc-50: Crisp, clean background with a warm undertone
    logoBorderBottom: '1px solid #f4f4f5',

    menuItemHoverColor: '#10b981',    // Emerald-500: Fresh green accent
    menuItemHoverBackgroundColor: '#f4f4f5', // Zinc-100

    menuItemActiveBackgroundColor: '#ecfdf5', // Emerald-50: Soft green block
    menuItemActiveTextColor: '#047857',       // Emerald-700: Strong contrast active text

    iconColor: '#71717a',             // Zinc-500
    iconHoverColor: '#10b981',
    iconActiveColor: '#047857',

    iconSize: 22,
    iconMinWidth: 30,
    breakpoint: 'sm',

    groupItemHoverColor: '#047857',
    groupItemHoverBackgroundColor: '#e4e4e7', // Zinc-200
    groupItemActiveBackgroundColor: '#f4f4f5',
    groupItemActiveTextColor: '#10b981',
    groupBackgroundColor: '#f4f4f5',  // Indented subgroups blend perfectly
  },

  topbar: {
    textColor: '#18181b',             // Zinc-900
    textSize: 16,
    backgroundColor: '#ffffff',
    menuItemHoverColor: '#10b981',
    iconColor: '#71717a',
    iconSize: 22,
    logoAlwaysVisible: true,
  },

  popupMenu: {
    backgroundColor: '#ffffff',
    textColor: '#27272a',             // Zinc-800
    textSize: 15,
    iconColor: '#71717a',
    iconSize: 18,
    dividerColor: '#f4f4f5',
    hoverColor: '#fafafa',
    activeColor: '#ecfdf5',
    selectedColor: '#ecfdf5',
  },

  mainContent: {
    textColor: '#27272a',
    backgroundColor: '#ffffff',       // Pure white content area makes elements pop
    padding: 24,
  },

  footer: {
    height: 56,
    padding: 0,
    textColor: '#71717a',
    backgroundColor: '#fafafa',
    borderTop: '1px solid #e4e4e7',
  },

  section: {
    textColor: '#059669',             // Emerald-600: Elegant section headers
    marginLeft: '15px',
  },
}