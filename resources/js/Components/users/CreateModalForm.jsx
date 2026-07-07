import React from 'react'
import { MyAutocompleteMultiField, MyEmailField, MyPasswordField, MyTextField } from '@artibet/react-mui-components/form-fields'
import { useForm } from 'react-hook-form'
import { yupResolver } from "@hookform/resolvers/yup"
import * as yup from "yup"
import {
  Button,
  Dialog,
  DialogActions,
  DialogContent,
  DialogTitle,
  Stack,
  Box,
  Typography,
  Zoom,
  Divider,
  CircularProgress,
} from '@mui/material'
import { emailRegEx } from '@artibet/react-mui-components/utils'
import { PersonAddAlt1Rounded } from '@mui/icons-material'

export const CreateModalForm = ({
  open,
  roles,
  onSubmit,
  onCancel,
  isLoading,
}) => {

  // ---------------------------------------------------------------------------------------
  // Default values
  // ---------------------------------------------------------------------------------------
  const defaultValues = {
    email: '',
    name: '',
    roles: [],
    password: '',
    password_confirmation: '',
  }

  // ---------------------------------------------------------------------------------------
  // Validation schema
  // ---------------------------------------------------------------------------------------
  const passwordRegEx = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*(),.?":{}|<>]).{8,}$/;

  const schema = yup.object({
    email: yup
      .string()
      .matches(emailRegEx, 'Μη έγκυρη μορφή Email')
      .max(255, 'Το email δεν πρέπει να υπερβαίνει τους 255 χαρακτήρες')
      .required('Καταχωρήστε το email του χρήστη'),
    name: yup
      .string()
      .max(255, 'Η επωνυμία δεν πρέπει να υπερβαίνει τους 255 χαρακτήρες')
      .required('Καταχωρήστε την επωνυμία του χρήστη'),
    roles: yup
      .array()
      .min(1, 'Επιλέξτε τουλάχιστον έναν ρόλο'),
    password: yup
      .string()
      .min(4, 'Ο κωδικός πρέπει να είναι τουλάχιστον 4 χαρακτήρες')
      .max(255, 'Ο κωδικός δεν πρέπει να υπερβαίνει τους 255 χαρακτήρες')
      .required('Καταχωρήστε τον κωδικό πρόσβασης του χρήστη'),
    password_confirmation: yup
      .string()
      .required('Επαληθεύστε τον κωδικό πρόσβασης του χρήστη')
      .oneOf([yup.ref('password'), null], 'Οι κωδικοί δεν ταιριάζουν')
  })

  // ---------------------------------------------------------------------------------------
  // State and hooks
  // ---------------------------------------------------------------------------------------
  const form = useForm({ defaultValues, resolver: yupResolver(schema) })

  // ---------------------------------------------------------------------------------------
  // Reset form on open
  // ---------------------------------------------------------------------------------------
  React.useEffect(() => {
    if (open) {
      form.clearErrors()
      form.reset(defaultValues)
    }
  }, [open, form])

  // ---------------------------------------------------------------------------------------
  // Close dialog handler
  // ---------------------------------------------------------------------------------------
  const handleClose = (e, reason) => {
    if (reason === 'escapeKeyDown') {
      onCancel();
    }
  }

  // ---------------------------------------------------------------------------------------
  // JSX
  // ---------------------------------------------------------------------------------------
  return (
    <Dialog
      fullWidth
      maxWidth="md"
      open={open}
      onClose={handleClose}
      disableRestoreFocus={false}
      slots={{ transition: Zoom }}
      slotProps={{
        paper: {
          sx: { borderRadius: 3, p: 1 }
        }
      }}
    >
      <DialogTitle sx={{ pb: 1 }}>
        <Stack direction="row" spacing={2} alignItems="center">
          <Box sx={{ bgcolor: 'primary.light', color: 'primary.main', p: 1, borderRadius: 2, display: 'flex' }}>
            <PersonAddAlt1Rounded />
          </Box>
          <Box>
            <Typography variant="h6" fontWeight={700}>Νέος Χρήστης</Typography>
            <Typography variant="caption" color="text.secondary">Συμπληρώστε τα στοιχεία του νέου χρήστη</Typography>
          </Box>
        </Stack>
      </DialogTitle>

      <Divider sx={{ mx: 3, opacity: 0.5 }} />
      <form onSubmit={form.handleSubmit(onSubmit)} noValidate>
        <DialogContent>
          <Stack spacing={2.5} sx={{ mt: 1 }}>

            {/* email */}
            <MyEmailField
              form={form}
              name='email'
              label='E-Mail'
              required
              autofocus
            />

            {/* name */}
            <MyTextField
              form={form}
              name='name'
              label='Επωνυμία'
              required
            />

            {/* roles */}
            <MyAutocompleteMultiField
              form={form}
              name='roles'
              label='Ρόλοι'
              options={roles}
              required
            />

            <Divider sx={{ my: 1 }}>
              <Typography variant="caption" color="text.disabled" fontWeight={700}>ΑΣΦΑΛΕΙΑ</Typography>
            </Divider>

            <Stack direction={{ xs: 'column', sm: 'row' }} spacing={2}>

              {/* password */}
              <MyPasswordField
                form={form}
                name='password'
                label='Κωδικός Πρόσβασης'
                required
                maxLength={255}
              />

              {/* password_confirmation */}
              <MyPasswordField
                form={form}
                name='password_confirmation'
                label='Επανάληψη Κωδικού Πρόσβασης'
                required
                maxLength={255}
              />

            </Stack>

          </Stack>

        </DialogContent>

        <DialogActions>
          <Button
            onClick={onCancel}
            color="inherit"
            sx={{ fontWeight: 700, color: 'text.secondary', minWidth: 150, }}
          >
            ΑΚΥΡΩΣΗ
          </Button>
          <Button
            type="submit"
            variant="contained"
            color="primary"
            disabled={isLoading}
            sx={{
              borderRadius: 2,
              px: 4,
              fontWeight: 700,
              boxShadow: 'none',
              minWidth: 150,
              '&:hover': { boxShadow: '0 4px 12px rgba(0,0,0,0.15)' }
            }}
          >
            {
              isLoading ? (
                <CircularProgress size={20} sx={{ color: 'inherit' }} />
              ) : (
                'ΚΑΤΑΧΩΡΗΣΗ'
              )
            }
          </Button>
        </DialogActions>
      </form>
    </Dialog >
  )
}
