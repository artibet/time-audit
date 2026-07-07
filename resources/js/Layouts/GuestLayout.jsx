import React from 'react'
import { Container, Typography, Box, Paper } from '@mui/material'
import { Footer } from '@/Layouts/Footer'
import { Head } from '@inertiajs/react'

export const GuestLayout = ({ children, title }) => {
  return (
    <Box
      sx={{
        display: 'flex',
        flexDirection: 'column',
        minHeight: '100vh',
        // A soft, modern background gradient
        background: 'linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%)',
      }}
    >
      <Head title={title} />

      <Container
        maxWidth="sm"
        sx={{
          flexGrow: 1,
          display: 'flex',
          flexDirection: 'column',
          justifyContent: 'center', // Centers the card vertically
          py: 4
        }}
      >
        {/* Logo & Header Section */}
        <Box sx={{ textAlign: 'center', mb: 4 }}>
          <Box
            component="img"
            src="/img/logo.png"
            alt="Logo"
            sx={{
              width: { xs: 250, sm: 300 }, // Responsive logo size
              height: 'auto',
              filter: 'drop-shadow(0px 4px 6px rgba(0,0,0,0.1))', // Elegant shadow
              mb: 1
            }}
          />
          <Typography
            variant="h5"
            sx={{ color: 'text.secondary', fontWeight: 500 }}
          >
            Εφαρμογή Διαχείρισης Υπερωριών
          </Typography>
        </Box>

        {/* Content Area (The Card will sit inside here) */}
        <Box sx={{ width: '100%' }}>
          {children}
        </Box>
      </Container>

      <Box sx={{ py: 3 }}>
        <Footer />
      </Box>
    </Box>
  )
}