import React from 'react'
import { router } from '@inertiajs/react'
import { formatDateTime, formatFloat } from '@artibet/react-mui-components/utils'
import { Card, CardContent } from '@mui/material'
import { ServerSideTable } from '@artibet/react-mui-components/tables'
import { AuthLayout } from '@/Layouts/AuthLayout'
import { StatusChip } from '@artibet/react-mui-components'
import { CreateModalForm } from '@/Components/users/CreateModalForm'
import { FlashMessages } from '@artibet/react-mui-components/inertiajs'
import { useModalForm } from '@artibet/react-mui-components/hooks';
import { SelectFileModalForm } from '@artibet/react-mui-components/modals'

const Index = ({ policy, url, roles }) => {

  // ---------------------------------------------------------------------------------------
  // State
  // ---------------------------------------------------------------------------------------
  const modalForm = useModalForm()

  // ---------------------------------------------------------------------------------------
  // Upload file handler
  // ---------------------------------------------------------------------------------------
  const handleImportFile = () => {
    modalForm.create({
      handleSubmit: data => {
        modalForm.submit('post', url.store, {
          descr: data.descr,
          file: data.filename
        })
      }
    })
  }

  // ---------------------------------------------------------------------------------------
  // Table columns
  // ---------------------------------------------------------------------------------------
  const columns = React.useMemo(() => [
    {
      id: 'descr',
      label: 'Περιγραφή',
    },
    {
      id: 'starts_at',
      label: 'Από',
      render: row => formatDateTime(row.starts_at)
    },
    {
      id: 'ends_at',
      label: 'Έως',
      render: row => formatDateTime(row.ends_at)
    },
    {
      id: 'employees_count',
      label: 'Πλήθος Υπαλλήλων',
      align: 'right',
    },
    {
      id: 'file_size',
      label: 'Μέγεθος Αρχείου',
      render: row => `${formatFloat(row.file_size / 1024, 2)} Kb`,
      align: 'right',
    },
    {
      id: 'created_at',
      label: 'Ημ/νία Εισαγωγής',
      render: row => formatDateTime(row.created_at)
    }

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
            title='Αρχεία Κινήσεων'
            columns={columns}
            dataUrl={url.ssp}
            enableCreateRow={policy.create}
            createButtonTooltip='Εισαγωγή Αρχείου'
            onCreateRow={handleImportFile}
            enableGlobalFilter={true}
            enableColumnFilters={false}
            globalFilterPlaceholder='Αναζήτηση'
            rowsClickable={true}
            onRowClick={row => router.get(row.url.show)}
            keepState={true}
            stateKey='upload-files'
          />
        </CardContent>
      </Card>
      <SelectFileModalForm
        open={modalForm.isOpen}
        acceptFiles='.xlsx'
        title='Εισαγωγή Αρχείου Κινήσεων'
        descriptionLabel='Περιγραφή Αρχείου'
        descriptionRequiredMessage='Παρακαλώ συμπληρώστε την περιγραφή του αρχείου'
        okLabel='ΕΙΣΑΓΩΓΗ'
        message='Επιλέξτε το αρχείο κινήσεων σε μορφή MS-EXCEL (.xlsx)'
        isLoading={modalForm.processing}
        onSubmit={modalForm.meta?.handleSubmit}
        onCancel={modalForm.close}
      />
    </>
  )
}

// Layout and export
Index.layout = page => <AuthLayout children={page} title="Αρχεία Κινήσεων" />
export default Index