import React from 'react'
import { MyTextField } from '@artibet/react-mui-components/form-fields'
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
import { GroupsOutlined } from '@mui/icons-material'

export const CreateModalForm = ({
  open,
  onSubmit,
  onCancel,
  isLoading,
}) => {

  // ---------------------------------------------------------------------------------------
  // Default values
  // ---------------------------------------------------------------------------------------
  const defaultValues = {
    am: '',
    lastname: '',
    firstname: '',
    card_no: '',
  }

  // ---------------------------------------------------------------------------------------
  // Validation schema
  // ---------------------------------------------------------------------------------------
  const schema = yup.object({
    am: yup
      .string()
      .max(255, 'Ο αριθμός μητρώου δεν πρέπει να υπερβαίνει τους 255 χαρακτήρες')
      .required('Καταχωρήστε τον αριθμό μητρώου του εργαζομένου'),
    lastname: yup
      .string()
      .max(255, 'Το επώνυμο δεν πρέπει να υπερβαίνει τους 255 χαρακτήρες')
      .required('Καταχωρήστε το επώνυμο του εργαζομένου'),
    firstname: yup
      .string()
      .max(255, 'Το όνομα δεν πρέπει να υπερβαίνει τους 255 χαρακτήρες')
      .required('Καταχωρήστε το όνομα του εργαζομένου'),
    card_no: yup
      .string()
      .max(255, 'Ο αριθμός της κάρτας να υπερβαίνει τους 255 χαρακτήρες')
      .required('Καταχωρήστε τον αριθμό της κάρτας του εργαζομένου'),

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
      maxWidth="sm"
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
          <Box sx={{ bgcolor: 'primary.main', color: 'white', p: 1, borderRadius: 2, display: 'flex' }}>
            <GroupsOutlined />
          </Box>
          <Box>
            <Typography variant="h6" fontWeight={700}>Νέος Εργαζόμενος</Typography>
            <Typography variant="caption" color="text.secondary">Συμπληρώστε τα στοιχεία του νέου εργαζομένου</Typography>
          </Box>
        </Stack>
      </DialogTitle>

      <Divider sx={{ mx: 3, opacity: 0.5 }} />
      <form onSubmit={form.handleSubmit(onSubmit)} noValidate>
        <DialogContent>
          <Stack spacing={2.5} sx={{ mt: 1 }}>

            {/* am */}
            <MyTextField
              form={form}
              name='am'
              label='Αριθμός Μητρώου'
              required
              autofocus
            />

            {/* lastname */}
            <MyTextField
              form={form}
              name='lastname'
              label='Επώνυμο'
              required
            />

            {/* firstname */}
            <MyTextField
              form={form}
              name='firstname'
              label='Όνομα'
              required
            />

            {/* card_no */}
            <MyTextField
              form={form}
              name='card_no'
              label='Αριθμός Κάρτας'
              required
            />

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
