import React from 'react'
import { Box, Typography } from '@mui/material'

export const Footer = () => {
  return (
    <Box sx={{ height: '100%', display: 'flex', justifyContent: 'center', alignItems: 'center' }}>
      <Typography>
        © {(new Date()).getFullYear()} ΔΙ.ΠΑ.Ε. - Τμήμα Πληροφορικής Σερρών
      </Typography>
    </Box>
  )
}

