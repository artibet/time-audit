import React from 'react'
import { Box } from '@mui/material'

export const SidebarLogo = () => {
  return (
    <Box sx={{ display: 'flex', flexDirection: 'column', alignItems: 'center' }}>
      <Box
        component="img"
        src="/img/logo.png"
        alt="Logo"
        sx={{
          width: { xs: 200, sm: 200 }, // Responsive logo size
          height: 'auto',
          filter: 'drop-shadow(0px 4px 6px rgba(0,0,0,0.1))', // Elegant shadow
          mt: 1,
          mb: 1,
        }}
      />
    </Box>
  )
}
