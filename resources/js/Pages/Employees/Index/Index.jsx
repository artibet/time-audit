import React from 'react'
import { router } from '@inertiajs/react'
import { Card, CardContent } from '@mui/material'
import { ServerSideTable } from '@artibet/react-mui-components/tables'
import { AuthLayout } from '@/Layouts/AuthLayout'
import { FlashMessages } from '@artibet/react-mui-components/inertiajs'
import { useModalForm } from '@artibet/react-mui-components/hooks';
import { CreateModalForm } from '../../../Components/empoloyees/CreateModalForm'

const Index = ({ policy, url }) => {

  // ---------------------------------------------------------------------------------------
  // State
  // ---------------------------------------------------------------------------------------
  const createModalForm = useModalForm()

  // ---------------------------------------------------------------------------------------
  // Create employee click handler
  // ---------------------------------------------------------------------------------------
  const handleCreateEmployee = () => {
    createModalForm.create({
      handleSubmit: data => {
        createModalForm.submit('post', url.store, {
          ...data,
        })
      }
    })
  }

  // ---------------------------------------------------------------------------------------
  // Table columns
  // ---------------------------------------------------------------------------------------
  const columns = React.useMemo(() => [
    {
      id: 'am',
      label: 'Α.Μ.',
    },
    {
      id: 'lastname',
      label: 'Επώνυμο',
    },
    {
      id: 'firstname',
      label: 'Όνομα',
    },
    {
      id: 'card_no',
      label: 'Αρ. Κάρτας',
    },
    {
      id: 'last_in',
      label: 'Τελευταία Είσοδος',
    },
    {
      id: 'last_out',
      label: 'Τελευταία Έξοδος',
    },

  ], [])


  // ---------------------------------------------------------------
  // JSX
  // ---------------------------------------------------------------
  return (
    <>
      <FlashMessages />
      <Card variant="outlined" sx={{ marginTop: 0, marginBottom: 0 }}>
        <CardContent>
          <ServerSideTable
            title='Εργαζόμενοι'
            columns={columns}
            dataUrl={url.ssp}
            enableCreateRow={policy.create}
            createButtonTooltip='Νέος Εργαζόμενος'
            onCreateRow={handleCreateEmployee}
            enableGlobalFilter={true}
            enableColumnFilters={true}
            globalFilterPlaceholder='Αναζήτηση'
            rowsClickable={true}
            onRowClick={row => router.get(row.url.show)}
            keepState={true}
            stateKey='employees'
          />
        </CardContent>
      </Card>
      <CreateModalForm
        open={createModalForm.isOpen}
        onSubmit={createModalForm.meta?.handleSubmit}
        onCancel={createModalForm.close}
        isLoading={createModalForm.processing}
      />
    </>
  )
}

// Layout and export
Index.layout = page => <AuthLayout children={page} title="Εργαζόμενοι" />
export default Index