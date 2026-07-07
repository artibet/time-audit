import React from 'react'
import { router } from '@inertiajs/react'
import { Button } from '@mui/material'
import { Delete } from '@mui/icons-material'
import { ConfirmationDialog } from '@artibet/react-mui-components/modals'

export const DeleteAction = ({ user }) => {

  // ---------------------------------------------------------------------------------------
  // State and context
  // ---------------------------------------------------------------------------------------
  const [showConfirm, setShowConfirm] = React.useState(false)
  const [isLoading, setIsLoading] = React.useState(false)

  // ---------------------------------------------------------------------------------------
  // click handler
  // ---------------------------------------------------------------------------------------
  const handleClick = e => {
    e.currentTarget.blur();
    setShowConfirm(true)
  }

  // ---------------------------------------------------------------------------------------
  // Submit handler
  // ---------------------------------------------------------------------------------------
  const handleSubmit = () => {
    setIsLoading(true)
    router.delete(user.url.delete, {
      onFinish: () => {
        setIsLoading(false)
        setShowConfirm(false)
      }
    })
  }

  // ---------------------------------------------------------------------------------------
  // JSX
  // ---------------------------------------------------------------------------------------
  if (!user.policy.delete) return null
  return (
    <>
      <Button
        variant="outlined"
        startIcon={<Delete />}
        color='error'
        sx={{ textTransform: 'none', fontWeight: 800, borderRadius: 2 }}
        onClick={handleClick}
      >
        Διαγραφή
      </Button>
      <ConfirmationDialog
        open={showConfirm}
        title='Διαγραφή Χρήστη'
        message='Να διαγραφεί ο επιλεγμένος Χρήστης-Μέλος της εφαρμογής;'
        onConfirm={handleSubmit}
        onCancel={() => setShowConfirm(false)}
        isLoading={isLoading}
      />
    </>
  )
}
