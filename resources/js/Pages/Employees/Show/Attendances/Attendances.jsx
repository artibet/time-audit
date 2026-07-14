import React from 'react'
import { ServerSideTable } from '@artibet/react-mui-components/tables'
import { usePage } from '@inertiajs/react'
import { Card, CardContent } from '@mui/material'
import { formatTime } from '@artibet/react-mui-components/utils'

export const Attendances = () => {

  // ---------------------------------------------------------------------------------------
  // State and context
  // ---------------------------------------------------------------------------------------
  const { employee } = usePage().props
  const months = [
    { id: 'Ιανουάριος', label: 'Ιανουάριος' },
    { id: 'Φεβρουάριος', label: 'Φεβρουάριος' },
    { id: 'Μάρτιος', label: 'Μάρτιος' },
    { id: 'Απρίλιος', label: 'Απρίλιος' },
    { id: 'Μάιος', label: 'Μάιος' },
    { id: 'Ιούνιος', label: 'Ιούνιος' },
    { id: 'Ιούλιος', label: 'Ιούλιος' },
    { id: 'Αύγουστος', label: 'Αύγουστος' },
    { id: 'Σεπτέμβριος', label: 'Σεπτέμβριος' },
    { id: 'Οκτώβριος', label: 'Οκτώβριος' },
    { id: 'Νοέμβριος', label: 'Νοέμβριος' },
    { id: 'Δεκέμβριος', label: 'Δεκέμβριος' },
  ]

  // ---------------------------------------------------------------------------------------
  // Table columns
  // ---------------------------------------------------------------------------------------
  const columns = React.useMemo(() => [
    {
      id: 'punch_year',
      label: 'Έτος',
    },
    {
      id: 'punch_month_name',
      label: 'Μήνας',
      filterType: 'autocomplete',
      filterOptions: months,
      filterValueKey: 'label',
      filterLabel_Key: 'label',
      minWidth: 180,
    },
    {
      id: 'punch_day',
      label: 'Ημέρα',
    },
    {
      id: 'shift_string',
      label: 'Ωράριο'
    },
    {
      id: 'punch_in',
      label: 'Προσήλθε',
      render: row => formatTime(row.punch_in)
    },
    {
      id: 'punch_out',
      label: 'Αποχώρησε',
      render: row => formatTime(row.punch_out)
    },
    {
      id: 'shift_minutes',
      label: 'Λεπτά Ωραρίου',
      align: 'right',
    },
    {
      id: 'worked_minutes',
      label: 'Λεπτά Εργασίας',
      align: 'right'
    },
    {
      id: 'work_balance_minutes',
      label: 'Απόκλιση',
      align: 'right'
    },
    {
      id: 'overtime_minutes',
      label: 'Υπερωρίες',
      align: 'right'
    },
  ], [])

  // ---------------------------------------------------------------------------------------
  // JSX
  // ---------------------------------------------------------------------------------------
  return (
    <Card variant="outlined" sx={{ marginTop: 0, marginBottom: 0 }}>
      <CardContent>
        <ServerSideTable
          title=''
          columns={columns}
          dataUrl={employee.url.ssp_attendances}
          enableCreateRow={false}
          createButtonTooltip=''
          onCreateRow={() => { }}
          enableGlobalFilter={true}
          enableColumnFilters={true}
          globalFilterPlaceholder='Αναζήτηση'
          rowsClickable={false}
          onRowClick={row => { }}
          keepState={true}
          stateKey={`employees-${employee.id}-attendances`}
        />
      </CardContent>
    </Card>
  )
}
