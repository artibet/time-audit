import React from 'react'
import { Button } from '@mui/material'
import { Delete } from '@mui/icons-material'
import { ConfirmationDialog } from '@artibet/react-mui-components/modals'
import { useConfirm } from '@artibet/react-mui-components/hooks'

export const DeleteAction = ({ uploadFile }) => {

  // ---------------------------------------------------------------------------------------
  // State and context
  // ---------------------------------------------------------------------------------------
  const deleteConfirm = useConfirm()

  // ---------------------------------------------------------------------------------------
  // click handler
  // ---------------------------------------------------------------------------------------
  const handleClick = e => {
    e.currentTarget.blur();
    deleteConfirm.open({
      title: 'Διαγραφή Αρχείου Κινήσεων',
      message: `Να διαγραφεί οριστικά το αρχείο κινήσεων '${uploadFile.descr}';`,
      onConfirm: () => {
        deleteConfirm.deleteRequest(uploadFile.url.delete)
      }

    })
  }

  // ---------------------------------------------------------------------------------------
  // JSX
  // ---------------------------------------------------------------------------------------
  if (!uploadFile.policy.delete) return null
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
        open={deleteConfirm.isOpen}
        title={deleteConfirm.data?.title}
        message={deleteConfirm.data?.message}
        onConfirm={deleteConfirm.data?.onConfirm}
        onCancel={deleteConfirm.close}
        isLoading={deleteConfirm.processing}
      />
    </>
  )
}
