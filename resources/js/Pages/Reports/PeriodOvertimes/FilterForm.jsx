import React from 'react'
import { FieldLabel, MyAutocompleteField } from '@artibet/react-mui-components/form-fields'
import { Box, Button, Card, CardContent, CircularProgress, Grid2, Stack } from '@mui/material'
import { useForm } from 'react-hook-form'
import { yupResolver } from "@hookform/resolvers/yup"
import * as yup from "yup"

export const FilterForm = ({
  onSubmit,
  onReset,
  isLoading,
  filters = null,
  years = [],
  months = [],
}) => {

  // ---------------------------------------------------------------------------------------
  // Default values
  // ---------------------------------------------------------------------------------------
  const defaultValues = {
    year: (filters && filters.year) ?? null,
    month_from: (filters && filters.month_from) ?? null,
    month_to: (filters && filters.month_to) ?? null,
  }

  // ---------------------------------------------------------------------------------------
  // Validation schema
  // ---------------------------------------------------------------------------------------
  const schema = yup.object({
    year: yup
      .number()
      .required('Επιλέξτε το έτος αναφοράς'),
    month_from: yup
      .number()
      .required('Επιλέξτε τον αρχικό μήνα υπολογισμού'),
    month_to: yup
      .number()
      .required('Επιλέξτε τον τελικό μήνα υπολογισμού'),
  })


  // ---------------------------------------------------------------------------------------
  // State and hooks
  // ---------------------------------------------------------------------------------------
  const form = useForm({ defaultValues, resolver: yupResolver(schema) })

  // ---------------------------------------------------------------------------------------
  // Reset form handler
  // ---------------------------------------------------------------------------------------
  const handleReset = () => {
    form.reset(defaultValues)
    if (onReset) {
      onReset()
    }
  }

  // ---------------------------------------------------------------------------------------
  // JSX
  // ---------------------------------------------------------------------------------------
  return (
    <Card variant="outlined" sx={{ mb: 4 }}>
      <CardContent>
        <form onSubmit={form.handleSubmit(onSubmit)} noValidate>

          <Grid2 container spacing={2.5} sx={{ mt: 1 }}>

            {/* year */}
            <Grid2 size={{ xs: 12, sm: 4 }}>
              <MyAutocompleteField
                form={form}
                name='year'
                label='Έτος Αναφοράς'
                options={years}
                required
                autofocus
              />
            </Grid2>

            {/* month_from */}
            <Grid2 size={{ xs: 12, sm: 4 }}>
              <MyAutocompleteField
                form={form}
                name='month_from'
                label='Από Μήνα'
                options={months}
                required
              />
            </Grid2>

            {/* month_to */}
            <Grid2 size={{ xs: 12, sm: 4 }}>
              <MyAutocompleteField
                form={form}
                name='month_to'
                label='Έως Μήνα'
                options={months}
                required
              />
            </Grid2>

            {/* submit and reset button */}
            <Box
              sx={{
                display: 'flex',
                justifyContent: 'center',
                mt: 1,
                mb: 1
              }}
            >
              <Stack
                direction="row"
                spacing={2}
                sx={{
                  width: '100%',
                  maxWidth: 400
                }}>
                <Button
                  type="submit"
                  variant="contained"
                  color="primary"
                  disabled={isLoading}
                  fullWidth
                  sx={{ height: 40 }}
                >
                  {isLoading ? (
                    <CircularProgress size={20} sx={{ color: 'inherit' }} />
                  ) : (
                    'ΥΠΟΒΟΛΗ'
                  )}
                </Button>

                <Button
                  type="button"
                  variant="outlined"
                  color="inherit"
                  onClick={handleReset}
                  disabled={isLoading}
                  fullWidth
                  sx={{ height: 40 }}
                >
                  ΚΑΘΑΡΙΣΜΟΣ
                </Button>
              </Stack>
            </Box>


          </Grid2>
        </form>
      </CardContent>
    </Card >
  )
}
