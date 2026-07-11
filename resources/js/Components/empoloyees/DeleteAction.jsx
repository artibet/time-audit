import React from 'react'
import { Button } from '@mui/material'
import { Delete } from '@mui/icons-material'
import { ConfirmationDialog } from '@artibet/react-mui-components/modals'
import { useConfirm } from '@artibet/react-mui-components/hooks'

export const DeleteAction = ({ employee }) => {

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
      title: 'Διαγραφή Εργαζομένου',
      message: `Να διαγραφεί οριστικά ο εργαζόμενος '${employee.fullname}';`,
      onConfirm: () => {
        deleteConfirm.deleteRequest(employee.url.delete)
      }

    })
  }

  // ---------------------------------------------------------------------------------------
  // JSX
  // ---------------------------------------------------------------------------------------
  if (!employee.policy.delete) return null
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
