import React from 'react'
import { AuthLayout } from '@/Layouts/AuthLayout'
import { Breadcrumbs, FlashMessages } from '@artibet/react-mui-components/inertiajs'
import { PageHeader, PageTitle } from '@artibet/react-mui-components'
import { DeleteAction } from '../../../Components/empoloyees/DeleteAction'
import { Box, Tab, Tabs } from '@mui/material'
import { Identity } from './Identity/Identity'
import { Punches } from './Punches/Punches'
import { Attendances } from './Attendances/Attendances'


export const Show = ({ employee }) => {

  // ---------------------------------------------------------------------------------------
  // State
  // ---------------------------------------------------------------------------------------
  const [tabValue, setTabValue] = React.useState('identity')

  // ---------------------------------------------------------------------------------------
  // JSX
  // ---------------------------------------------------------------------------------------
  return (
    <>
      <FlashMessages />
      <PageTitle title='Προβολή Εργαζομένου' />
      <Breadcrumbs />
      <PageHeader
        title={employee.fullname}
        globalActions={<DeleteAction employee={employee} />}
        createdAt={employee.created_at}
        updatedAt={employee.updated_at}
      />

      {/* Tabs */}
      <Box sx={{ marginTop: 2, width: '100%' }}>
        <Box sx={{ borderBottom: 1, borderColor: 'divider' }}>
          <Tabs value={tabValue} onChange={(_, value) => setTabValue(value)}>
            <Tab sx={{ fontSize: 16 }} label='ΣΤΟΙΧΕΙΑ ΕΡΓΑΖΟΜΕΝΟΥ' value='identity' />
            <Tab sx={{ fontSize: 16 }} label='ΚΙΝΗΣΕΙΣ ΚΑΡΤΑΣ' value='punches' />
            <Tab sx={{ fontSize: 16 }} label='ΠΑΡΟΥΣΙΟΛΟΓΙΟ' value='attendances' />
          </Tabs>
        </Box>
      </Box>

      {/* Tab panels */}
      {tabValue === 'identity' && <Identity />}
      {tabValue === 'punches' && <Punches />}
      {tabValue === 'attendances' && <Attendances />}
    </>
  )
}


// Layout and export
Show.layout = page => <AuthLayout children={page} title="Προβολή Εργαζομένου" />
export default Show