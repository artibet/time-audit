import React from 'react'
import { TextModalForm } from '@artibet/react-mui-components/modals'
import { LockReset } from '@mui/icons-material'
import { Button, } from '@mui/material'
import { router } from '@inertiajs/react'

export const ResetPasswordAction = ({ user }) => {

  // ---------------------------------------------------------------------------------------
  // State
  // ---------------------------------------------------------------------------------------
  const [showForm, setShowForm] = React.useState(false)
  const [isLoading, setIsLoading] = React.useState(false)

  // ---------------------------------------------------------------------------------------
  // click handler
  // ---------------------------------------------------------------------------------------
  const handleClick = e => {
    e.currentTarget.blur();
    setShowForm(true)
  }

  // ---------------------------------------------------------------------------------------
  // Submit handler
  // ---------------------------------------------------------------------------------------
  const handleSubmit = (password) => {
    setIsLoading(true)
    router.post(`/users/${user.id}/reset-password`, {
      password
    }, {
      onFinish: () => {
        setIsLoading(false)
        setShowForm(false)
      }
    })
  }

  // ---------------------------------------------------------------------------------------
  // JSX
  // ---------------------------------------------------------------------------------------
  if (!user.policy.reset_password) return null

  return (
    <>
      <Button
        variant="outlined"
        startIcon={<LockReset />}
        color='primary'
        sx={{ textTransform: 'none', fontWeight: 800, borderRadius: 2 }}
        onClick={handleClick}
      >
        Αλλαγή Κωδικού
      </Button>
      <TextModalForm
        open={showForm}
        title='Επαναφορά Κωδικού Πρόσβασης'
        label='Νέος Κωδικός Πρόσβασης'
        value=''
        requiredMessage='Συμπληρώστε τον νέο κωδικό πρόσβασης'
        onSubmit={handleSubmit}
        onCancel={() => setShowForm(false)}
        isLoading={isLoading}
      />
    </>
  )
}
