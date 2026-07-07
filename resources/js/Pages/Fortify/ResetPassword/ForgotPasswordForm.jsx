import React from 'react'
import { router } from '@inertiajs/react'
import { Stack, Box, Button } from '@mui/material'
import { yupResolver } from "@hookform/resolvers/yup"
import { emailRegEx } from '@artibet/react-mui-components/utils'
import * as yup from "yup"
import { useForm } from 'react-hook-form'
import { MyEmailField } from '@artibet/react-mui-components/form-fields'

// *****************************************************************************************
export const ForgotPasswordForm = () => {

  // ---------------------------------------------------------------------------------------
  // Default values
  // ---------------------------------------------------------------------------------------
  const defaultValues = React.useMemo(() => {
    return {
      email: '',
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

  })

  // ---------------------------------------------------------------------------------------
  // State and hooks
  // ---------------------------------------------------------------------------------------
  const form = useForm({ defaultValues, resolver: yupResolver(schema) })

  // ---------------------------------------------------------------
  // Submit handler
  // ---------------------------------------------------------------
  const handleSubmit = (values) => {
    router.post('/forgot-password', values)
  }

  // ---------------------------------------------------------------
  // JSX
  // ---------------------------------------------------------------
  return (
    <form onSubmit={form.handleSubmit(handleSubmit)} noValidate>
      <Stack gap={3}>
        <MyEmailField form={form} label='Email' required autofocus />
      </Stack>
      <Box sx={{ marginTop: 4 }}>
        <Button
          type="submit"
          variant="contained"
          sx={{ width: '100%' }}
        >
          ΥΠΟΒΟΛΗ
        </Button>
      </Box>
    </form>
  )
}
