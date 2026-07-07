import React from 'react'
import { Box, Card, CardContent, CardHeader, Typography } from '@mui/material'
import { LoginForm } from './LoginForm'
import { GuestLayout } from '@/Layouts/GuestLayout'
import { FlashMessages } from '@artibet/react-mui-components/inertiajs'

const Login = () => {

  // ---------------------------------------------------------------
  // Styles
  // ---------------------------------------------------------------
  const styles = {
    wrapper: {
      display: 'flex',
      flexDirection: 'column',
      alignItems: 'center',
      padding: 2,
    }
  }

  // ---------------------------------------------------------------
  // JSX
  // ---------------------------------------------------------------
  return (
    <Box sx={styles.wrapper}>

      <Card variant="outlined"
        sx={{
          marginTop: 4,
          marginBottom: 4,
          width: '100%',
          maxWidth: '500px',
          borderRadius: 3,
          boxShadow: '0 8px 24px rgba(0,0,0,0.12)',
          border: 'none'
        }}
      >
        <CardHeader title="Σύνδεση στην εφαρμογή" sx={{ textAlign: 'center' }} />
        <CardContent>
          <FlashMessages />
          <LoginForm />
        </CardContent>
      </Card>
    </Box>
  )
}

// Layout and export
Login.layout = page => <GuestLayout children={page} title="Σύνδεση στην εφαρμογή" />
export default Login