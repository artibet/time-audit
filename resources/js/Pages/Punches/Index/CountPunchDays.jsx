import React from 'react'
import { Card, CardContent } from '@mui/material'
import { ServerSideTable } from '@artibet/react-mui-components/tables'
import { AuthLayout } from '@/Layouts/AuthLayout'
import { FlashMessages } from '@artibet/react-mui-components/inertiajs'

const CountPunchDays = ({ url }) => {

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
      id: 'days_with_1_punch',
      label: '1 Χτύπ.',
      align: 'right',
    },
    {
      id: 'days_with_2_punches',
      label: '2 Χτυπ.',
      align: 'right',
    },
    {
      id: 'days_with_3_punches',
      label: '3 Χτυπ.',
      align: 'right',
    },
    {
      id: 'days_with_4_punches',
      label: '4 Χτυπ.',
      align: 'right',
    },
    {
      id: 'days_with_over_4_punches',
      label: '>4 Χτυπ.',
      align: 'right',
    },
    {
      id: 'total_worked_days',
      label: 'Σύνολο Ημερών',
      align: 'right',
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
            title='Χτυπήματα Ανά Ημέρα'
            columns={columns}
            dataUrl={url.ssp}
            enableCreateRow={false}
            createButtonTooltip=''
            onCreateRow={null}
            enableGlobalFilter={true}
            enableColumnFilters={true}
            globalFilterPlaceholder='Αναζήτηση'
            rowsClickable={false}
            onRowClick={row => { }}
            keepState={true}
            stateKey='count-punches'
          />
        </CardContent>
      </Card>
    </>
  )
}

// Layout and export
CountPunchDays.layout = page => <AuthLayout children={page} title="Χτυπήματα Ανά Ημέρα" />
export default CountPunchDays