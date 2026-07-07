import React from 'react'
import { AuthLayout } from '@/Layouts/AuthLayout'
import { Breadcrumbs, FlashMessages } from '@artibet/react-mui-components/inertiajs'
import { PageHeader, PageTitle } from '@artibet/react-mui-components'
import { Identity } from './Identity'
import { DeleteAction } from '@/Components/users/DeleteAction'
import { ResetPasswordAction } from '@/Components/users/ResetPasswordAction'
import { Stack } from '@mui/material'

export const Show = ({ user }) => {

  // ---------------------------------------------------------------------------------------
  // JSX
  // ---------------------------------------------------------------------------------------
  return (
    <>
      <FlashMessages />
      <PageTitle title='Προβολή Χρήστη' />
      <Breadcrumbs />
      <PageHeader
        title={user.name}
        globalActions={<GlobalActions user={user} />}
        createdAt={user.created_at}
        updatedAt={user.updated_at}
      />

      {/* identity */}
      <Identity />
    </>
  )
}

// ---------------------------------------------------------------------------------------
// Global actions
// ---------------------------------------------------------------------------------------
const GlobalActions = ({ user }) => {
  return (
    <Stack gap={1} direction='row'>
      <DeleteAction user={user} />
      <ResetPasswordAction user={user} />
    </Stack>
  )
}

// Layout and export
Show.layout = page => <AuthLayout children={page} title="Προβολή Χρήστη" />
export default Show