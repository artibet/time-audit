import React from 'react'
import { router } from '@inertiajs/react'
import { Stack, Box, Button } from '@mui/material'
import { yupResolver } from "@hookform/resolvers/yup"
import * as yup from "yup"
import { useForm } from 'react-hook-form'
import { MyEmailField, MyPasswordField } from '@artibet/react-mui-components/form-fields'
import { emailRegEx } from '@artibet/react-mui-components/utils'

// *****************************************************************************************
export const ResetPasswordForm = ({ token }) => {

  // ---------------------------------------------------------------------------------------
  // Default values
  // ---------------------------------------------------------------------------------------
  const defaultValues = {
    email: '',
    password: '',
    password_confirmation: '',
    token: token,
  }

  // ---------------------------------------------------------------------------------------
  // Validation schema
  // ---------------------------------------------------------------------------------------
  const schema = yup.object({
    email: yup
      .string()
      .matches(emailRegEx, 'Μη έγκυρη μορφή Email')
      .max(255, 'Το email δεν πρέπει να υπερβαίνει τους 255 χαρακτήρες')
      .required('Καταχωρήστε το email σας'),
    password: yup
      .string()
      .max(255, 'Ο κωδικός δεν πρέπει να υπερβαίνει τους 255 χαρακτήρες')
      .min(4, 'Ο κωδικός πρέπει να αποτελείται από τουλάχιστον 4 χαρακτήρες')
      .required('Καταχωρήστε το νέο κωδικό πρόσβασης'),
    password_confirmation: yup
      .string()
      .required('Επαληθεύστε το νέο κωδικό πρόσβασης')
      .oneOf([yup.ref('password'), null], 'Οι κωδικοί δεν ταιριάζουν')
  })

  // ---------------------------------------------------------------------------------------
  // State and hooks
  // ---------------------------------------------------------------------------------------
  const form = useForm({ defaultValues, resolver: yupResolver(schema) })
  const { formState: { isSubmitting } } = form

  // ---------------------------------------------------------------
  // Submit handler
  // ---------------------------------------------------------------
  const handleSubmit = (values) => {
    router.post('/reset-password', values)
  }

  // ---------------------------------------------------------------
  // JSX
  // ---------------------------------------------------------------
  return (
    <form onSubmit={form.handleSubmit(handleSubmit)} noValidate>

      <Stack sx={{ marginTop: 2 }} gap={3}>

        {/* email */}
        <MyEmailField
          form={form}
          name='email'
          label='E-Mail'
          required
          autofocus
        />

        {/* password */}
        <MyPasswordField
          form={form}
          name='password'
          label='Νέος Κωδικός'
          required
          maxLength={255}
        />

        {/* password_confirmation */}
        <MyPasswordField
          form={form}
          name='password_confirmation'
          label='Επαλήθευση Κωδικού'
          required
          maxLength={255}
        />

      </Stack>

      <Box sx={{ marginTop: 4 }}>
        <Button
          type="submit"
          variant="contained"
          fullWidth
          disabled={isSubmitting}
          sx={{
            py: 1.2,
            borderRadius: 2,
            fontWeight: 700
          }}
        >
          {isSubmitting ? 'ΕΠΕΞΕΡΓΑΣΙΑ...' : 'ΑΛΛΑΓΗ ΚΩΔΙΚΟΥ'}
        </Button>
      </Box>
    </form>
  )
}
