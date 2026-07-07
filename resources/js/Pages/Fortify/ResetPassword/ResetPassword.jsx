import React from 'react'
import { Box, Card, CardContent, Typography } from '@mui/material'
import { ResetPasswordForm } from './ResetPasswordForm'
import { FlashMessages } from '@artibet/react-mui-components/inertiajs'
import { GuestLayout } from '@/Layouts/GuestLayout'

function PasswordReset({ token }) {
  return (
    <Box sx={{ display: 'flex', flexDirection: 'column', alignItems: 'center', width: '100%' }}>
      <Typography
        variant="h4"
        sx={{
          marginTop: 2,
          fontWeight: 700,
          textAlign: 'center',
          fontSize: { xs: '1.5rem', sm: '2.125rem' }
        }}
      >
        Δημιουργία Νέου Κωδικού
      </Typography>

      <Card
        elevation={3}
        sx={{
          marginTop: 4,
          marginBottom: 4,
          width: '100%',
          maxWidth: '500px', // Fluid width
          borderRadius: 3,
          border: 'none'
        }}
      >
        <CardContent sx={{ p: { xs: 3, sm: 4 } }}>
          <FlashMessages />
          <ResetPasswordForm token={token} />
        </CardContent>
      </Card>
    </Box>
  )
}

// Layout and export
PasswordReset.layout = page => <GuestLayout children={page} title="Δημιουργία Νέου Κωδικού Πρόσβασης" />
export default PasswordReset