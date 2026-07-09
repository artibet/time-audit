import React from 'react'
import { router } from '@inertiajs/react'
import { Card, CardContent } from '@mui/material'
import { ServerSideTable } from '@artibet/react-mui-components/tables'
import { AuthLayout } from '@/Layouts/AuthLayout'
import { StatusChip } from '@artibet/react-mui-components'
import { CreateModalForm } from '@/Components/users/CreateModalForm'
import { FlashMessages } from '@artibet/react-mui-components/inertiajs'
import { useModalForm } from '@artibet/react-mui-components/hooks';

const Index = ({ policy, url, roles }) => {

  // ---------------------------------------------------------------------------------------
  // State
  // ---------------------------------------------------------------------------------------
  const userModalForm = useModalForm()
  const yesNoOptions = [{ id: 'ΝΑΙ', label: 'ΝΑΙ' }, { id: 'ΟΧΙ', label: 'ΟΧΙ' }]

  // ---------------------------------------------------------------------------------------
  // Create user click handler
  // ---------------------------------------------------------------------------------------
  const handleCreateUser = () => {
    userModalForm.create({
      handleSubmit: data => {
        userModalForm.submit('post', url.store, {
          ...data,
          roles: data.roles.map(role => role.id)
        })
      }
    })
  }

  // ---------------------------------------------------------------------------------------
  // Table columns
  // ---------------------------------------------------------------------------------------
  const columns = React.useMemo(() => [
    {
      id: 'is_active_label',
      label: 'Κατάσταση',
      render: row => <StatusChip isActive={row.is_active} label={row.is_active_label} inactiveBgColor='error.main' inactiveColor='#ffffff' inactiveVariant='filled' />,
      filterType: 'autocomplete',
      filterOptions: [{ id: 'Ενεργός', label: 'Ενεργός' }, { id: 'Ανενεργός', label: 'Ανενεργός' }]
    },
    {
      id: 'name',
      label: 'Επωνυμία',
    },
    {
      id: 'email',
      label: 'E-mail',
    },
    {
      id: 'is_superadmin_label',
      label: 'Υπέρ-Διαχειριστής',
      render: row => <StatusChip isActive={row.is_superadmin_label == 'ΝΑΙ'} activeBgColor='rgba(25, 118, 210, 0.3)' activeColor='primary.dark' label={row.is_superadmin_label} />,
      filterType: 'autocomplete',
      filterOptions: [{ id: 'ΝΑΙ', label: 'ΝΑΙ' }, { id: 'ΟΧΙ', label: 'ΟΧΙ' }]
    },
    {
      id: 'is_admin_label',
      label: 'Διαχειριστής',
      render: row => <StatusChip isActive={row.is_admin_label == 'ΝΑΙ'} activeBgColor='rgba(25, 118, 210, 0.3)' activeColor='primary.dark' label={row.is_admin_label} />,
      filterType: 'autocomplete',
      filterOptions: [{ id: 'ΝΑΙ', label: 'ΝΑΙ' }, { id: 'ΟΧΙ', label: 'ΟΧΙ' }]
    },
    {
      id: 'is_editor_label',
      label: 'Συντάκτης',
      render: row => <StatusChip isActive={row.is_editor_label == 'ΝΑΙ'} activeBgColor='rgba(25, 118, 210, 0.3)' activeColor='primary.dark' label={row.is_editor_label} />,
      filterType: 'autocomplete',
      filterOptions: yesNoOptions
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
            title='Χρήστες & Ρόλοι'
            columns={columns}
            dataUrl={url.ssp}
            enableCreateRow={policy.create}
            createButtonTooltip='Νέος Χρήστης'
            onCreateRow={handleCreateUser}
            enableGlobalFilter={true}
            enableColumnFilters={true}
            globalFilterPlaceholder='Αναζήτηση'
            rowsClickable={true}
            onRowClick={row => router.get(row.url.show)}
            keepState={true}
            stateKey='users'
          />
        </CardContent>
      </Card>
      <CreateModalForm
        open={userModalForm.isOpen}
        roles={roles}
        onSubmit={userModalForm.meta?.handleSubmit}
        onCancel={userModalForm.close}
        isLoading={userModalForm.processing}
      />
    </>
  )
}

// Layout and export
Index.layout = page => <AuthLayout children={page} title="Χρήστες - Μέλη" />
export default Index