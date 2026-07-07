import React from 'react'
import { Box, Card, CardContent, Typography, Link as MuiLink, Paper } from '@mui/material'
import { ForgotPasswordForm } from './ForgotPasswordForm'
import { FlashMessages } from '@artibet/react-mui-components/inertiajs'
import { GuestLayout } from '@/Layouts/GuestLayout'
import { router } from '@inertiajs/react'

function ForgotPassword(props) {
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
        Επαναφορά Κωδικού
      </Typography>

      {props.status ? (
        <Paper
          elevation={0}
          sx={{
            marginTop: 4,
            padding: 4,
            textAlign: 'center',
            bgcolor: 'success.light',
            color: 'success.contrastText',
            borderRadius: 2
          }}
        >
          <Typography sx={{ fontWeight: 500 }} variant='h6'>
            {props.status}
          </Typography>
          <MuiLink
            component="button"
            onClick={() => router.get('/login')}
            sx={{ mt: 2, color: 'inherit', fontWeight: 700 }}
          >
            Επιστροφή στη σύνδεση
          </MuiLink>
        </Paper>
      ) : (
        <Card
          elevation={3} // Using shadow instead of outline for elegance
          sx={{
            marginTop: 4,
            marginBottom: 4,
            width: '100%',
            maxWidth: '500px', // Responsive container
            borderRadius: 3,
            border: 'none'
          }}
        >
          <CardContent sx={{ p: { xs: 3, sm: 4 } }}> {/* Extra padding on larger screens */}
            <FlashMessages />

            <Typography
              sx={{
                marginBottom: 4,
                fontSize: 16,
                color: 'text.secondary',
                lineHeight: 1.6,
                textAlign: 'center'
              }}
            >
              Εισάγετε το email σας και θα σας αποστείλουμε έναν σύνδεσμο για τη δημιουργία νέου κωδικού πρόσβασης.
            </Typography>

            <ForgotPasswordForm />

            <Box sx={{ mt: 3, textAlign: 'center' }}>
              <MuiLink
                component="button"
                variant="body2"
                onClick={() => router.get('/login')}
                sx={{ textDecoration: 'none', fontWeight: 600 }}
              >
                Επιστροφή στη σύνδεση
              </MuiLink>
            </Box>
          </CardContent>
        </Card>
      )}
    </Box>
  )
}

ForgotPassword.layout = page => <GuestLayout children={page} title="Επαναφορά Κωδικού Πρόσβασης" />

export default ForgotPassword