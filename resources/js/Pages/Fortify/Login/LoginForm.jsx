import React from 'react'
import { Stack, Box, Button, CircularProgress } from '@mui/material'
import { router } from '@inertiajs/react'
import { emailRegEx } from '@artibet/react-mui-components/utils'
import { useForm } from 'react-hook-form'
import { yupResolver } from "@hookform/resolvers/yup"
import * as yup from "yup"
import { MyEmailField, MyPasswordField } from '@artibet/react-mui-components/form-fields'
import { Link as MuiLink } from '@mui/material'
import { Login as LoginIcon } from '@mui/icons-material'


export const LoginForm = () => {

  // ---------------------------------------------------------------------------------------
  // Default values
  // ---------------------------------------------------------------------------------------
  const defaultValues = React.useMemo(() => {
    return {
      email: '',
      password: ''
    }
  }, [])

  // ---------------------------------------------------------------------------------------
  // Validation schema
  // ---------------------------------------------------------------------------------------
  const schema = yup.object({
    email: yup
      .string()
      .matches(emailRegEx, 'Μη έγκυρη μορφή Email')
      .required('Πληκτρολογείστε το email σας'),
    password: yup
      .string()
      .required('Πληκτρολογείστε τον κωδικό πρόσβασης'),

  })

  // ---------------------------------------------------------------------------------------
  // State and hooks
  // ---------------------------------------------------------------------------------------
  const form = useForm({ defaultValues, resolver: yupResolver(schema) })
  const [isLoading, setIsLoading] = React.useState(false)
  const { handleSubmit } = form

  // ---------------------------------------------------------------
  // Handle Login
  // ---------------------------------------------------------------
  const handleLogin = (data) => {
    setIsLoading(true)
    router.post('/login', data, {
      onFinish: () => setIsLoading(false)
    })
  }


  // ---------------------------------------------------------------
  // JSX
  // ---------------------------------------------------------------
  return (
    <form onSubmit={handleSubmit(handleLogin)} noValidate>
      <Stack gap={{ xs: 3, sm: 5 }}>
        <MyEmailField form={form} label='Email' autofocus />
        <MyPasswordField form={form} required />
      </Stack>

      <Box sx={{ display: 'flex', justifyContent: 'end', mt: 1 }}>
        <MuiLink
          component="button"
          type="button"
          variant="body2"
          onClick={() => router.get('/forgot-password')}
          sx={{
            color: 'text.secondary',
            textDecoration: 'none',
            '&:hover': {
              textDecoration: 'underline',
              color: 'primary.main',
            },
            fontSize: '0.8rem',
            fontWeight: 500,
          }}
        >
          Ξεχάσατε τον κωδικό σας;
        </MuiLink>
      </Box>

      <Box sx={{ marginTop: 2 }}>
        <Button
          type="submit"
          variant="contained"
          fullWidth
          disabled={isLoading} // Disables button during request
          startIcon={!isLoading && <LoginIcon />} // Shows icon only when not loading
          sx={{
            py: 1.2,
            borderRadius: 2,
            fontWeight: 700,
            boxShadow: 'none',
            '&:hover': { boxShadow: '0 4px 12px rgba(0,0,0,0.15)' }
          }}
        >
          {isLoading ? (
            <CircularProgress size={24} sx={{ color: 'inherit' }} />
          ) : (
            'ΣΥΝΔΕΣΗ'
          )}
        </Button>
      </Box>
    </form>
  )
}
